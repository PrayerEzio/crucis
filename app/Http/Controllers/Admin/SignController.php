<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Sign;
use App\Http\Services\QiniuService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Sign $sign)
    {
        $where = [];
        $input = $request->all();
        $list = $sign->where($where)->orderBy('created_at','desc')->paginate(10);
        return view('Admin.Sign.index')->with(compact('list','input'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Sign $sign)
    {
        $data = $sign->findOrFail($id);
        return view('Admin.Sign.create')->with(compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Sign $sign)
    {
        $data = $sign->findOrFail($id);
        return view('Admin.Sign.create')->with(compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,Sign $sign,QiniuService $qiniuService)
    {
        $sign = $sign->findOrFail($id);
        if ($request->file('image'))
        {
            $file = $request->file('image');
            $sign->image = $qiniuService->upload($file);
        }
        $sign->balance = $request->balance;
        $sign->point = $request->point;
        $res = $sign->save();
        if ($res)
        {
            $alert = ['success','操作成功'];
        }else {
            $alert = ['error','操作失败'];
        }
        return redirect(config('crucis.app_url') . '/Admin/Sign')->with('alert', $alert);
    }
}
