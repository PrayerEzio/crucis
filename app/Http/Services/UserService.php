<?php
/**
 * Copyright (c) 2019. Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan. 
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna. 
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus. 
 * Vestibulum commodo. Ut rhoncus gravida arcu. 
 */

namespace App\Http\Services;
use App\Http\Models\BalanceLogs;
use App\Http\Models\PointLogs;
use App\Http\Models\User;
use App\Http\Models\UserInvitation;
use Illuminate\Support\Facades\DB;

class UserService
{
    protected $repository;

    public function __construct()
    {
        $this->user = new User();
        $this->balanceLogs = new BalanceLogs();
        $this->pointLogs = new PointLogs();
    }

    public function addBalance($user_id,$amount,$title)
    {
        DB::beginTransaction(); //事务开始
        try{
            $this->user->userId($user_id)->increment('balance',$amount);
            $this->balanceLogs->title = $title;
            $this->balanceLogs->user_id = $user_id;
            $this->balanceLogs->amount = $amount;
            $this->balanceLogs->save();
            DB::commit();//提交事务
            return true;
        } catch(QueryException $ex) {
            DB::rollback(); //回滚事务
            return false;
        }
    }

    public function addPoint($user_id,$amount,$title)
    {
        DB::beginTransaction(); //事务开始
        try{
            $this->user->userId($user_id)->increment('point',$amount);
            $this->pointLogs->title = $title;
            $this->pointLogs->user_id = $user_id;
            $this->pointLogs->amount = $amount;
            $this->pointLogs->save();
            DB::commit();//提交事务
            return true;
        } catch(QueryException $ex) {
            DB::rollback(); //回滚事务
            return false;
        }
    }

    public function reduceBalance($user_id,$amount,$title)
    {
        DB::beginTransaction(); //事务开始
        try{
            $this->user->userId($user_id)->decrement('balance',$amount);
            $this->balanceLogs->title = $title;
            $this->balanceLogs->user_id = $user_id;
            $this->balanceLogs->amount = $amount*-1;
            $this->balanceLogs->save();
            DB::commit();//提交事务
            return true;
        } catch(QueryException $ex) {
            DB::rollback(); //回滚事务
            return false;
        }
    }

    public function reducePoint($user_id,$amount,$title)
    {
        DB::beginTransaction(); //事务开始
        try{
            $this->user->userId($user_id)->decrement('point',$amount);
            $this->pointLogs->title = $title;
            $this->pointLogs->user_id = $user_id;
            $this->pointLogs->amount = $amount*-1;
            $this->pointLogs->save();
            DB::commit();//提交事务
            return true;
        } catch(QueryException $ex) {
            DB::rollback(); //回滚事务
            return false;
        }
    }
}