<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Models\Address;
use App\Http\Models\Order;
use App\Http\Models\Product;
use App\Http\Models\User;
use App\Transformers\OrderTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends BaseController
{
    /**
     * 获取订单列表
     *
     * 注意Response结构,带分页meta信息
     *
     * @Get("/order")
     * @Versions({"v1"})
     * @Request(headers={"Authorization": "Bearer+token"})
     * @Parameters({
     *     @Parameter("page", description="页码",required=false,default=1),
     * })
     * @Transaction({
     *     @Response(200, body="{order_list}"),
     * })
     */
    public function index(Order $order)
    {
        $data = $order->userId($this->getUserInfo()->id)->get();
        return $this->response->collection($data,new OrderTransformer());
    }

    protected function create_order_sn()
    {
        return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    }

    /**
     * 创建订单(兑换商品)
     *
     * 创建订单并用积分支付
     *
     * @Post("/order")
     * @Versions({"v1"})
     * @Request(headers={"Authorization": "Bearer+token"})
     * @Parameters({
     *     @Parameter("product_sn", description="所需兑换的product_sn",required=true),
     *     @Parameter("address_id", description="实体物品的收货地址",required=false),
     *     @Parameter("phone", description="虚拟物品的收货地址",required=false),
     * })
     * @Transaction({
     *     @Response(200, body={"status_code":500,"message":"{error_message}"}),
     *     @Response(200, body={"status_code":200,"message":"{success_message}"}),
     * })
     */
    public function create(Request $request,Order $order,Product $product)
    {
        $product_sn = $request->product_sn;
        $order_sn = $this->create_order_sn();
        $user_id = $this->getUserInfo()->id;
        if (empty($product_sn))
        {
            return $this->response->array([
                "message" => "请选择商品!",
                "status_code" => 500,
            ]);
        }
        $product_info = $product
            ->productSn($product_sn)
            ->where('stock','>',0)
            ->where('status',1)
            ->first();
        if (empty($product_info))
        {
            return $this->response->array([
                "message" => "该商品暂时无法购买!",
                "status_code" => 500,
            ]);
        }
        if (!$product_info->goods->is_virtual)
        {
            if (empty($request->address_id))
            {
                return $this->response->array([
                    "message" => "请填写收货地址信息!",
                    "status_code" => 500,
                ]);
            }
            $address_id = $request->address_id;
        } else {
            if (empty($request->phone))
            {
                if (!is_mobile_number($request->phone))return $this->response->array(["message" => "请填写正确的手机号码!", "status_code" => 500,]);
                return $this->response->array([
                    "message" => "请填写充值号码!",
                    "status_code" => 500,
                ]);
            } else {
                $address = new Address();
                $virtual_address_where[] = ['user_id',$user_id];
                $virtual_address_where[] = ['phone',$request->phone];
                $virtual_address_where[] = ['tag',"虚拟地址"];
                $virtual_address_where[] = ['status',0];
                $address = $address->where($virtual_address_where)->first();
                if (!$address)
                {
                    $address = new Address();
                    $address->user_id = $user_id;
                    $address->phone = $request->phone;
                    $address->tag = "虚拟地址";
                    $address->status = 0;
                    $address->name = "";
                    $address->province_id = 1;
                    $address->city_id = 1;
                    $address->district_id = 1;
                    $address->address = "";
                    $address->save();
                }
                $address_id = $address->id;
            }
        }
        //订单生成事务
        DB::beginTransaction(); //事务开始
        try {
            $order->order_sn = $order_sn;
            $order->order_type = 'point_shopping';
            $order->user_id = $user_id;
            $order->address_id = $address_id;
            $order->amount = $product_info->price;
            $order->status = 1;
            $order->save();
            //减库存
            $product->where('id',$product_info->id)
                ->where('stock','>',1)
                ->where('status',1)
                ->decrement('stock',1);
            $temp_item['product_id'] = $product_info->id;
            $temp_item['goods_name'] = $product_info->goods->name;
            $temp_item['mkt_price'] = $product_info->mkt_price ? floatval($product_info->mkt_price) : 0.00;
            $temp_item['price'] = $product_info->price ? floatval($product_info->price) : 0.00;
            $temp_item['qty'] = 1;
            $temp_item['picture'] = $product_info->goods->picture;
            $product_list[] = $temp_item;
            $order->products()->createMany($product_list);
            $order->logs()->create([
                'title' => '创建订单',
                'operator' => "用户id-{$user_id}",
                'content' => '创建订单成功',
                'level' => 0,
                'status' => 1,
            ]);
            $pay_result = $this->payOrder($order_sn,'point');
            if (!$pay_result)
            {
                DB::rollback(); //回滚事务
                //异常处理
                return $this->response->array([
                    "message" => "订单支付失败!",
                    "status_code" => 500,
                ]);
            }
            DB::commit(); //提交事务
        } catch(QueryException $ex) {
            DB::rollback(); //回滚事务
            //异常处理
            return $this->response->array([
                "message" => "订单生成失败!",
                "status_code" => 500,
            ]);
        }
        return $this->response->array([
            "message" => "订单生成成功!",
            "status_code" => 200,
            "data" => ['order_sn'=>$order_sn]
        ]);
    }

    private function payOrder($sn,$payment_method)
    {
        $order = new Order();
        $user = new User();
        $uid = $this->getUserInfo()->id;
        $order_info = $order->orderSn($sn)->userId($uid)->status(1)->first();
        if (empty($order_info)) return false;
        DB::beginTransaction(); //事务开始
        try {
            switch ($payment_method) {
                case 'point':
                    $res = $user->userId($uid)
                        ->where('point','>=',$order_info->amount)
                        ->decrement('point',$order_info->amount);
                    if (!$res)
                    {
                        DB::rollback();
                        return false;
                    }
                    $order_info->status = 2;//1未支付 2已支付 3已发货 4已收货 5已完成 -1取消
                    break;
                case 'alipay':
                    break;
                case 'wechat':
                    break;
                case 'paypal':
                    break;
                default:
                    return false;
                    break;
            }
            $order_info->save();
            $order_info->logs()->create([
                'title' => "支付订单",
                'operator' => "用户id-{$uid}",
                'content' => "支付订单-积分支付",
                'level' => 0,
                'status' => 1,
            ]);
            DB::commit();//提交事务
            return true;
        } catch(QueryException $ex) {
            DB::rollback(); //回滚事务
            //异常处理
            return false;
        }
    }

    /**
     * 获取订单详情
     *
     * @Get("/order/{order_sn}")
     * @Versions({"v1"})
     * @Request(headers={"Authorization": "Bearer+token"})
     * @Parameters({
     * })
     * @Transaction({
     *     @Response(200, body="{order_sn}"),
     * })
     */
    public function show($order_sn)
    {
        $order = new Order();
        $data = $order->userId($this->getUserInfo()->id)->orderSn($order_sn)->first();
        return $this->response->item($data,new OrderTransformer());
    }
}
