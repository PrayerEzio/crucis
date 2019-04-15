<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\User;
use App\Http\Services\QiniuService;
use Illuminate\Http\Request;
use Crypt;

class UserController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $list = $user->get();
        return view('Admin.User.index')->with(compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.User.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,User $user,QiniuService $qiniuService)
    {
        if ($request->file('avatar'))
        {
            $file = $request->file('avatar');
            $user->avatar = $qiniuService->upload($file);
        }
        $user->nickname = $request->nickname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->store_name = $request->store_name;
        $user->balance = $request->balance;
        $user->point = $request->point;
        $user->password = Crypt::encrypt($request->password);
        $user->status = $request->status == 'on' ? 1 : 0;
        $res = $user->save();
        if ($res)
        {
            $alert = ['success','操作成功'];
            return redirect(config('crucis.app_url') . '/Admin/User')->with('alert', $alert);
        }else {
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        dd($request->method());
        dd("this is show action id:{$id}");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user,$id)
    {
        $data = $user->findOrFail($id);
        return view('Admin.User.create')->with(compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, QiniuService $qiniuService)
    {
        $user = $user->findOrFail($request->id);
        if ($request->file('avatar'))
        {
            $file = $request->file('avatar');
            $user->avatar = $qiniuService->upload($file);
        }
        $user->nickname = $request->nickname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->store_name = $request->store_name;
        $user->balance = $request->balance;
        $user->point = $request->point;
        if ($request->password)
        {
            $user->password = Crypt::encrypt($request->password);
        }
        $user->status = $request->status == 'on' ? 1 : 0;
        $res = $user->save();
        if ($res)
        {
            $alert = ['success','操作成功'];
        }else {
            $alert = ['error','操作失败'];
        }
        return redirect(config('crucis.app_url') . "/Admin/User")->with('alert', $alert);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        $res = $user->destroy($request->id);
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
