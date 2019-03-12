<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;

use Illuminate\Routing\Controller as BaseController;

use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        //
    }

    protected function getSmsCode($phone,$type="register")
    {
        return Cache::get("sms_code_{$type}_{$phone}");
    }

    //获取请求的方法
    protected function requestMethod()
    {
        $request = new Request();
        return strtoupper($request->method());
    }

    /**
     * 获取子级ID
     * @param array $array 集合数组
     * @param int $pid 父级ID
     * @param string $idKey 索引键名
     * @param string $pidKey 父级关联键名
     * @return Ambigous <multitype:, multitype:unknown >
     */
    protected function getChildsId($array, $pid = 0, $id_name = 'id', $pid_name = 'parent_id', $loop = 999999){
        $arr = array();
        if (!$loop)
        {
            return $arr;
        }
        $loop--;
        foreach ($array as $v){
            if ($v[$pid_name] == $pid) {
                $arr[] = $v[$id_name];
                $arr = array_merge($arr, $this->getChildsId($array, $v[$id_name], $id_name, $pid_name,$loop));
            }
        }
        return $arr;
    }

    protected function unlimitedForLayer($cate, $child_name = 'child' , $pid_name = 'parent_id' , $id_name = 'id',$pid = 0){
        $arr = array();
        foreach ($cate as $v){
            if ($v[$pid_name] == $pid){
                $v[$child_name] = $this->unlimitedForLayer($cate,$child_name,$pid_name,$id_name,$v[$id_name]);
                $arr[] = $v;
            }
        }
        return $arr;
    }
    //传递一个子分类ID返回所有的父级分类
    protected function getParents($cate, $id, $pid_name = 'parent_id', $id_name = 'id') {
        $arr = array();
        foreach ($cate as $v){
            if ($v[$id_name]==$id) {
                $arr[]=$v;
                $arr = array_merge($this->getParents($cate, $v[$pid_name] , $pid_name, $id_name),$arr);
            }
        }
        return $arr;
    }
}