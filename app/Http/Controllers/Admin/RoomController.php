<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Models\Room;
use App\Http\Services\QiniuService;
use Illuminate\Http\Request;

class RoomController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,Room $room)
    {
        $where = [];
        $input = $request->all();
        if (!empty($input['keyword'])) $where[] = ['title','like',"%{$input['keyword']}%"];
        if (!empty($input['id'])) $where[] = ['id',"{$input['id']}"];
        $list = $room->where($where)->orderBy('created_at','desc')->paginate(10);
        return view('Admin.Room.index')->with(compact('list','input'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Room $room)
    {
        $data = $room->findOrFail($id);
        return view('Admin.Room.create')->with(compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Room $room)
    {
        $data = $room->findOrFail($id);
        return view('Admin.Room.create')->with(compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,Room $room,QiniuService $qiniuService)
    {
        $room = $room->findOrFail($id);
        if ($request->file('cover'))
        {
            $file = $request->file('cover');
            $room->cover = $qiniuService->upload($file);
        }
        if ($request->file('music'))
        {
            $file = $request->file('music');
            $room->music = $qiniuService->upload($file);
        }
        $room->title = $request->title;
        $room->is_mainten = $request->status == 'on' ? 0 : 1;
        $res = $room->save();
        if ($res)
        {
            $alert = ['success','操作成功'];
        }else {
            $alert = ['error','操作失败'];
        }
        return redirect(config('crucis.app_url') . '/Admin/Room')->with('alert', $alert);
    }
}
