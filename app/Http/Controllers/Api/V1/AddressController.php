<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Models\Address;
use App\Transformers\AddressTransformer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AddressController extends BaseController
{
    /**
     * 获取地址列表
     *
     * @Get("/address")
     * @Versions({"v1"})
     * @Request(headers={"Authorization": "Bearer+token"})
     * @Parameters({
     * })
     * @Transaction({
     * })
     */
    public function index(Address $address)
    {
        $data = $address->userId($this->getUserInfo()->id)->status(1)->get();
        return $this->response->collection($data,new AddressTransformer());
    }

    /**
     * 新增地址
     *
     * @Post("/address")
     * @Versions({"v1"})
     * @Request(headers={"Authorization": "Bearer+token"})
     * @Parameters({
     *     @Parameter("name", description="姓名",required=true),
     *     @Parameter("phone", description="手机号",required=true),
     *     @Parameter("province", description="省份",required=true),
     *     @Parameter("city", description="城市",required=true),
     *     @Parameter("district", description="县区",required=false),
     *     @Parameter("address", description="地址",required=true),
     *     @Parameter("tag", description="标签",required=false),
     *     @Parameter("is_default", description="是否默认",required=false,default=false),
     *     @Parameter("status", description="状态",required=false),
     * })
     * @Transaction({
     *     @Response(200, body={"status_code":500,"message":"{error_message}"}),
     *     @Response(200, body={"status_code":200,"message":"创建地址成功!"}),
     * })
     */
    public function store(Request $request,Address $address)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return $this->response->array([
                "message" => "请填写必填信息!",
                "status_code" => 500,
            ]);
        }

        $address->user_id = $this->getUserInfo()->id;
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->province = $request->province;
        $address->city = $request->city;
        $address->district = $request->district;
        $address->province_id = 1;
        $address->city_id = 1;
        $address->district_id = 1;
        $address->address = $request->address;
        $address->is_default = $request->is_default;
        $address->tag = $request->tag;
        $address->status = 1;

        if ($address->save()) {
            if ($request->is_default == 1) {
                $address_model = new Address();
                $address_model->userId($this->getUserInfo()->id)->update(['is_default' => false]);
                $address_model->where('id',$address->id)->update(['is_default' => true]);
            }
            return $this->response->array([
                "message" => "创建地址成功!",
                "status_code" => 200,
            ]);
        } else {
            return $this->response->array([
                "message" => "创建地址失败!",
                "status_code" => 500,
            ]);
        }
    }

    /**
     * 获取单条地址
     *
     * @Get("/address/{id}")
     * @Versions({"v1"})
     * @Request(headers={"Authorization": "Bearer+token"})
     * @Parameters({
     * })
     * @Transaction({
     *     @Response(200, body="{address_data}"),
     * })
     */
    public function show($id)
    {
        $address = new Address();
        $data = $address->userId($this->getUserInfo()->id)->find($id);
        return $this->response->item($data,new AddressTransformer());
    }

    /**
     * 编辑地址
     *
     * @Post("/address/{id}")
     * @Versions({"v1"})
     * @Request(headers={"Authorization": "Bearer+token"})
     * @Parameters({
     *     @Parameter("name", description="姓名",required=true),
     *     @Parameter("phone", description="手机号",required=true),
     *     @Parameter("province", description="省份",required=true),
     *     @Parameter("city", description="城市",required=true),
     *     @Parameter("district", description="县区",required=false),
     *     @Parameter("address", description="地址",required=true),
     *     @Parameter("tag", description="标签",required=false),
     *     @Parameter("is_default", description="是否默认",required=false,default=false),
     *     @Parameter("status", description="状态",required=false),
     * })
     * @Transaction({
     *     @Response(200, body={"status_code":500,"message":"{error_message}"}),
     *     @Response(200, body={"status_code":200,"message":"编辑地址成功!"}),
     * })
     */
    public function update(Request $request, $id,Address $address)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return $this->response->array([
                "message" => "请填写必填信息!",
                "status_code" => 500,
            ]);
        }

        $address = $address->userId($this->getUserInfo()->id)->findOrFail($id);
        $address->user_id = $this->getUserInfo()->id;
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->province = $request->province;
        $address->city = $request->city;
        $address->district = $request->district;
        $address->province_id = 1;
        $address->city_id = 1;
        $address->district_id = 1;
        $address->address = $request->address;
        $address->is_default = $request->is_default;
        $address->tag = $request->tag;
        $address->status = 1;

        if ($address->save()) {
            if ($request->is_default == 1) {
                $address_model = new Address();
                $address_model->userId($this->getUserInfo()->id)->update(['is_default' => false]);
                $address_model->where('id',$address->id)->update(['is_default' => true]);
            }
            return $this->response->array([
                "message" => "编辑地址成功!",
                "status_code" => 200,
            ]);
        } else {
            return $this->response->array([
                "message" => "编辑地址失败!",
                "status_code" => 500,
            ]);
        }
    }

    /**
     * 删除地址
     *
     * @Delete("/address/{id}")
     * @Versions({"v1"})
     * @Request(headers={"Authorization": "Bearer+token"})
     * @Parameters({
     * })
     * @Transaction({
     *     @Response(200, body={"status_code":500,"message":"{error_message}"}),
     *     @Response(200, body={"status_code":200,"message":"删除地址成功"}),
     * })
     */
    public function destroy($id)
    {
        $address = new Address();
        $result = $address->userId($this->getUserInfo()->id)->where('id',$id)->delete();
        if ($result)
        {
            return $this->response->array([
                "message" => "删除地址成功!",
                "status_code" => 200,
            ]);
        } else {
            return $this->response->array([
                "message" => "删除地址失败!",
                "status_code" => 500,
            ]);
        }
    }

    protected function validator(array $data) {
        return Validator::make($data, [
            'name' => 'required',
            'phone' => 'required|min:11|max:11',
            'province' => 'required',
            'city' => 'required',
            'address' => 'required',
        ]);
    }
}
