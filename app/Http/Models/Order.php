<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'orders';

    public function user()
    {
        return $this->belongsTo('App\Http\Models\User', 'user_id');
    }

    public function products()
    {
        return $this->hasMany('App\Http\Models\OrderProduct','order_id','id');
    }

    public function logs()
    {
        return $this->hasMany('App\Http\Models\OrderLog','order_id','id');
    }

    public function address()
    {
        return $this->hasOne('App\Http\Models\Address','id','address_id');
    }

    public function scopeOrderSn($query,$sn)
    {
        return $query->where('order_sn',$sn);
    }

    public function scopeUserId($query,$user_id)
    {
        return $query->where('user_id',$user_id);
    }

    public function scopeStatus($query,$status)
    {
        return $query->where('status',$status);
    }

    public function scopeOrderType($query,$order_type)
    {
        return $query->where('order_type',$order_type);
    }

    static public function getStatusName($order)
    {
        if (empty($order)) return '';
        //1未支付 2已支付 3已发货 4已收货 5已完成 -1取消
        switch ($order->status)
        {
            case -1:
                $status_name = '已取消';
                break;
            case 1:
                $status_name = '未支付';
                break;
            case 2:
                $status_name = '已支付';
                break;
            case 3:
                $status_name = '已发货';
                break;
            case 4:
                $status_name = '已收货';
                break;
            case 5:
                $status_name = '已完成';
                break;
            default:
                $status_name = '异常状态';
                break;
        }
        return $status_name;
    }

    static public function getOrderTypeName($order)
    {
        if (empty($order)) return '';
        //1未支付 2已支付 3已发货 4已收货 5已完成 -1取消
        switch ($order->order_type)
        {
            case 'recharge':
                $status_name = '充值订单';
                break;
            case 'point_shopping':
                $status_name = '积分商城购物';
                break;
            default:
                $status_name = '未知类型';
                break;
        }
        return $status_name;
    }
}
