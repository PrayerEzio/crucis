<?php
/**
 * Copyright (c) 2018. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Models\Attribute;
use App\Http\Models\AttributeCategory;
use App\Http\Models\Goods;
use App\Http\Models\GoodsCategory;
use App\Http\Models\GoodsPicture;
use App\Http\Models\Product;
use App\Http\Services\QiniuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GoodsController extends CommonController
{
    public function goodsCategoryList()
    {
        return view('Admin.Goods.goods_category_list');
    }

    public function addCategory(Request $request,GoodsCategory $goodsCategory,$id,QiniuService $qiniuService)
    {
        if ($request->isMethod('post'))
        {
            if ($request->file('image'))
            {
                $goodsCategory->image = $qiniuService->upload($request->file('image'));
            }
            $goodsCategory->name = $request->name;
            $goodsCategory->parent_id = $id;
            $goodsCategory->sort = $request->sort;
            $goodsCategory->status = $request->status == 'on' ? 1 : 0;
            $res = $goodsCategory->save();
            if ($res)
            {
                $alert = ['success','操作成功'];
                return redirect('/Admin/Goods/goodsCategoryList')->with('alert',$alert);
            }else {
                return redirect()->back()->withInput()->withErrors('保存失败！');
            }
        }else {
            return view('Admin.Goods.add_category');
        }
    }

    public function editCategory(Request $request,GoodsCategory $goodsCategory,$id,QiniuService $qiniuService)
    {
        if ($request->isMethod('post'))
        {
            $goodsCategory = $goodsCategory->findOrFail($id);
            if ($request->file('image'))
            {
                $goodsCategory->image = $qiniuService->upload($request->file('image'));
            }
            $goodsCategory->name = $request->name;
            $goodsCategory->parent_id = $request->parent_id;
            $goodsCategory->sort = $request->sort;
            $goodsCategory->status = $request->status == 'on' ? 1 : 0;
            $res = $goodsCategory->save();
            if ($res)
            {
                $alert = ['success','操作成功'];
            }else {
                $alert = ['error','操作失败'];
            }
            return redirect('/Admin/Goods/goodsCategoryList')->with('alert',$alert);
        }else {
            $data = $goodsCategory->findOrFail($request->id);
            return view('Admin.Goods.add_category')->with(compact('data'));
        }
    }

    public function deleteGoodsCategory(Request $request,GoodsCategory $goodsCategory)
    {
        $res = false;
        $child_count = $goodsCategory->where('parent_id',$request->id)->count();
        if (!$child_count)
        {
            $res = $goodsCategory->destroy($request->id);
        }
        if ($res)
        {
            return response([
                'status'  => 200,
                'message' => __('Operation succeed.'),
                'data' => $res
            ]);
        }else {
            return response([
                'status'  => 500,
                'message' => __('Operation fail.'),
                'data' => $res
            ]);
        }
    }

    public function goodsList(Request $request,Goods $goods)
    {
        $where = [];
        $input = $request->all();
        if (!empty($input['keyword'])) $where[] = ['name','like',"%{$input['keyword']}%"];
        if (!empty($input['goods_sn'])) $where[] = ['goods_sn','like',"%{$input['goods_sn']}%"];
        $list = $goods->where($where)->orderBy('created_at','desc')->paginate(10);
        return view('Admin.Goods.goods_list')->with(compact('list','input'));
    }

    public function addGoods(Request $request,Goods $goods,GoodsCategory $goodsCategory,AttributeCategory $attributeCategory,Attribute $attribute,QiniuService $qiniuService)
    {
        if ($request->isMethod('post'))
        {
            $validator = $this->validator($request->all());
            if ($validator->fails()) {
                $alert = ['error','缺少必填参数'];
                return redirect()->back()->with('alert',$alert);
            }
            if (empty($request->product))
            {
                $alert = ['error','请选择商品的规格并生成产品'];
                return redirect()->back()->with('alert',$alert);
            }
            if (!$request->file('picture'))
            {
                $alert = ['error','请上传商品图片'];
                return redirect()->back()->with('alert',$alert);
            }
            DB::beginTransaction(); //事务开始
            try {
                $fillable_filed = ['category_id','goods_sn','name','sub_title','tag','description','seo_title','seo_keywords','seo_description','sort','detail','wholesale_number'];
                if ($request->file('picture'))
                {
                    $goods->picture = $qiniuService->upload($request->file('picture'));
                }
                foreach ($fillable_filed as $item)
                {
                    $goods->$item = $request->$item;
                }
                $goods->is_virtual = $request->is_virtual == 'on' ? 1 : 0;
                $goods->status = $request->status == 'on' ? 1 : 0;
                $goods->save();
                foreach ($request->product as $key => $item)
                {
                    $product = new Product();
                    $product->goods_id = $goods->id;
                    $product->product_sn = $item['product_sn'];
                    $product->mkt_price = $item['mkt_price'];
                    $product->price = $item['price'];
                    $product->stock = $item['stock'];
                    $product->sort = $item['sort'];
                    $product->status = 1;
                    $product->save();
                    foreach ($item['attribute'] as $item)
                    {
                        $product->attributes()->attach($item);
                    }
                }
                DB::commit(); //提交事务
                $res = true;
            } catch(QueryException $ex) {
                DB::rollback(); //回滚事务
                //异常处理
                $res = false;
            }
            if ($res)
            {
                $alert = ['success','操作成功'];
            }else {
                $alert = ['error','操作失败'];
            }
            return redirect("/Admin/Goods/goodsList/{$request->category_id}")->with('alert',$alert);
        }else {
            $cate_list = $goodsCategory->get();
            $cate_list = $this->unlimitedForLayer($cate_list);
            $attribute_category_list = $attributeCategory->get();
            $attribute_list = $attribute->get();
            return view('Admin.Goods.add_goods')->with(compact('cate_list','attribute_category_list','attribute_list'));
        }
    }

    public function editGoods($id,Request $request,Goods $goods,GoodsCategory $goodsCategory,AttributeCategory $attributeCategory,Attribute $attribute,QiniuService $qiniuService)
    {
        if ($request->isMethod('post'))
        {
            $validator = $this->validator($request->all());
            if ($validator->fails()) {
                $alert = ['error','缺少必填参数'];
                return redirect()->back()->with('alert',$alert);
            }
            if (empty($request->product))
            {
                $alert = ['error','请选择商品的规格并生成产品'];
                return redirect()->back()->with('alert',$alert);
            }
            DB::beginTransaction(); //事务开始
            try {
                $goods = $goods->findOrFail($request->id);
                $fillable_filed = ['category_id','goods_sn','name','sub_title','tag','description','seo_title','seo_keywords','seo_description','sort','detail','wholesale_number'];
                if ($request->file('picture'))
                {
                    $goods->picture = $qiniuService->upload($request->file('picture'));
                }
                foreach ($fillable_filed as $item)
                {
                    $goods->$item = $request->$item;
                }
                $goods->is_virtual = $request->is_virtual == 'on' ? 1 : 0;
                $goods->status = $request->status == 'on' ? 1 : 0;
                $goods->save();
                $product = new Product();
                $product->whereGoodsId($goods->id)->delete();
                //软删除旧产品 新增新产品
                foreach ($request->product as $key => $item)
                {
                    $product = new Product();
                    $product->goods_id = $goods->id;
                    $product->product_sn = $item['product_sn'];
                    $product->mkt_price = $item['mkt_price'];
                    $product->price = $item['price'];
                    $product->stock = $item['stock'];
                    $product->sort = $item['sort'];
                    $product->status = $goods->status;
                    $product->save();
                    //重写所有规格
                    foreach ($item['attribute'] as $item)
                    {
                        $product->attributes()->attach($item);
                    }
                }
                DB::commit(); //提交事务
                $res = true;
            } catch(QueryException $ex) {
                DB::rollback(); //回滚事务
                //异常处理
                $res = false;
            }
            if ($res)
            {
                $alert = ['success','操作成功'];
            }else {
                $alert = ['error','操作失败'];
            }
            return redirect("/Admin/Goods/goodsList/{$request->category_id}")->with('alert',$alert);
        }else {
            $cate_list = $goodsCategory->get();
            $cate_list = $this->unlimitedForLayer($cate_list);
            $attribute_category_list = $attributeCategory->get();
            $attribute_list = $attribute->get();
            $goods_info = $goods->findOrFail($id);
            $product_attributes_category = [];
            foreach ($goods_info->products as $product)
            {
                foreach ($product->attributes as $attribute)
                {
                    if (!in_array($attribute->category->name,$product_attributes_category))
                    {
                        $product_attributes_category[] = $attribute->category->name;
                    }
                }
            }
            $goods_info->product_attributes_category = $product_attributes_category;
            return view('Admin.Goods.add_goods')->with(compact('goods_info','cate_list','attribute_category_list','attribute_list'));
        }
    }

    public function addGoodsPicture($goods_id,Request $request,GoodsPicture $goodsPicture,QiniuService $qiniuService)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction(); //事务开始
            try {
                $goodsPicture->goods_id = $goods_id;
                $fillable_filed = ['sort'];
                if ($request->file('picture'))
                {
                    $goodsPicture->url = $qiniuService->upload($request->file('picture'));
                }
                foreach ($fillable_filed as $item)
                {
                    $goodsPicture->$item = $request->$item;
                }
                $goodsPicture->status = $request->status == 'on' ? 1 : 0;
                $goodsPicture->save();
                DB::commit(); //提交事务
                $res = true;
            } catch(QueryException $ex) {
                DB::rollback(); //回滚事务
                //异常处理
                $res = false;
            }
            if ($res)
            {
                $alert = ['success','操作成功'];
            }else {
                $alert = ['error','操作失败'];
            }
            return redirect("/Admin/Goods/goodsPictureList/{$goods_id}")->with('alert',$alert);
        }else {
            return view('Admin.Goods.add_goods_picture');
        }
    }

    public function editGoodsPicture($id,Request $request,GoodsPicture $goodsPicture,QiniuService $qiniuService)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction(); //事务开始
            try {
                $goods_picture_info = $goodsPicture->findOrFail($request->id);
                $fillable_filed = ['sort'];
                if ($request->file('picture'))
                {
                    $goods_picture_info->url = $qiniuService->upload($request->file('picture'));
                }
                foreach ($fillable_filed as $item)
                {
                    $goods_picture_info->$item = $request->$item;
                }
                $goods_picture_info->status = $request->status == 'on' ? 1 : 0;
                $goods_picture_info->save();
                DB::commit(); //提交事务
                $res = true;
            } catch(QueryException $ex) {
                DB::rollback(); //回滚事务
                //异常处理
                $res = false;
            }
            if ($res)
            {
                $alert = ['success','操作成功'];
            }else {
                $alert = ['error','操作失败'];
            }
            return redirect("/Admin/Goods/goodsPictureList/{$goods_picture_info->goods_id}")->with('alert',$alert);
        }else {
            $goods_picture_info = $goodsPicture->findOrFail($id);
            return view('Admin.Goods.add_goods_picture')->with(compact('goods_picture_info'));
        }
    }

    public function goodsPictureList($goods_id,Request $request,GoodsPicture $goodsPicture)
    {
        $where = [];
        $input = $request->all();
        if (!empty($input['goods_id'])) $where[] = ['goods_id',$input['goods_id']];
        $list = $goodsPicture->where($where)->orderBy('created_at','desc')->paginate(10);
        return view('Admin.Goods.goods_picture_list')->with(compact('list','input','goods_id'));
    }

    public function deleteGoodsPicture(Request $request,GoodsPicture $goodsPicture)
    {
        if ($request->isMethod('delete'))
        {
            $res = $goodsPicture->destroy($request->id);
            if ($res)
            {
                return response([
                    'status'  => 200,
                    'message' => __('Operation succeed.'),
                    'data' => $res
                ]);
            }else {
                return response([
                    'status'  => 500,
                    'message' => __('Operation fail.'),
                    'data' => $res
                ]);
            }
        }
    }

    public function deleteGoods(Request $request,Goods $goods,Product $product)
    {
        if ($request->isMethod('delete'))
        {
            $res = $goods->destroy($request->id);
            if ($res)
            {
//                $product->whereGoodsId($goods->id)->update(['status'=>0]);
                $product->whereGoodsId($goods->id)->delete();
                return response([
                    'status'  => 200,
                    'message' => __('Operation succeed.'),
                    'data' => $res
                ]);
            }else {
                return response([
                    'status'  => 500,
                    'message' => __('Operation fail.'),
                    'data' => $res
                ]);
            }
        }
    }

    protected function validator(array $data) {
        return Validator::make($data, [
            'goods_sn' => 'required',
            'name' => 'required'
        ]);
    }
}
