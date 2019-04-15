<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends CommonController
{
    public function orderList(Order $order,Request $request)
    {
        $where = [];
        $input = $request->all();
        !empty($input['sn']) ? $where[] = ['order_sn','like',"%{$input['sn']}%"] : $input['sn'] = '';
        !empty($input['status']) ? $where[] = ['status','=',$input['status']] : $input['status'] = '';
        !empty($input['start']) ? $where[] = ['created_at','>',$input['start'].' 00:00:00'] : $input['start'] = '';
        !empty($input['end']) ? $where[] = ['created_at','<=',$input['end'].' 23:59:59'] : $input['end'] = '';
        $list = $order->where($where)->orderBy('created_at','desc')->paginate(10);
        return view('Admin.Order.order_list')->with(compact('list','input'));
    }

    public function detail($sn,Order $order)
    {
        $order_info = $order->orderSn($sn)->first();
        return view('Admin.Order.detail')->with(compact('order_info'));
    }

    public function cancelOrder($sn,Order $order,Request $request)
    {
        if ($request->isMethod('delete'))
        {
            $order_info = $order->orderSn($sn)->first();
            DB::beginTransaction(); //事务开始
            try{
                //TODO:处理取消订单 根据订单状态回滚库存等相关数据 并记录日志
                switch ($order_info->status)
                {
                    default:
                        break;
                }
                DB::commit();//提交事务
                return response([
                    'status'  => 200,
                    'message' => __('Operation success.'),
                ]);
            } catch(QueryException $ex) {
                DB::rollback(); //回滚事务
                //异常处理
                return response([
                    'status'  => 500,
                    'message' => __('Operation fail.'),
                ]);
            }
        }
    }

    public function nextStatus(Order $order,Request $request)
    {
        $order_info = $order->orderSn($request->sn)->first();
        DB::beginTransaction(); //事务开始
        try{
            switch ($order_info->status)
            {
                case 1:
                    $order_info->status = 2;
                    $order_info->save();
                    $order_info->logs()->create([
                        'title' => "支付订单",
                        'operator' => "管理员-{$this->getAdminId()}",
                        'content' => "订单支付成功",
                        'ip' => $request->getClientIp(),
                        'level' => 0,
                        'status' => 1,
                    ]);
                    break;
                case 2:
                    $order_info->status = 3;
                    $order_info->save();
                    $order_info->logs()->create([
                        'title' => "订单发货",
                        'operator' => "管理员-{$this->getAdminId()}",
                        'content' => "订单确认发货",
                        'ip' => $request->getClientIp(),
                        'level' => 0,
                        'status' => 1,
                    ]);
                    break;
                case 3:
                    $order_info->status = 4;
                    $order_info->save();
                    $order_info->logs()->create([
                        'title' => "订单收货",
                        'operator' => "管理员-{$this->getAdminId()}",
                        'content' => "订单确认收货",
                        'ip' => $request->getClientIp(),
                        'level' => 0,
                        'status' => 1,
                    ]);
                    break;
                case 4:
                    $order_info->status = 5;
                    $order_info->save();
                    $order_info->logs()->create([
                        'title' => "订单完成",
                        'operator' => "管理员-{$this->getAdminId()}",
                        'content' => "订单确定完成",
                        'ip' => $request->getClientIp(),
                        'level' => 0,
                        'status' => 1,
                    ]);
                    break;
                default:
                    break;
            }
            DB::commit();//提交事务
            return response([
                'status'  => 200,
                'message' => __('Operation success.'),
            ]);
        } catch(QueryException $ex) {
            DB::rollback(); //回滚事务
            //异常处理
            return response([
                'status'  => 500,
                'message' => __('Operation fail.'),
            ]);
        }
    }
}
