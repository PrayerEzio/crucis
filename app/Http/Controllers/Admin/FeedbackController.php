<?php
/**
 * Copyright (c) 2019. Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan. 
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna. 
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus. 
 * Vestibulum commodo. Ut rhoncus gravida arcu. 
 */

namespace App\Http\Controllers\Admin;

use App\Http\Models\Feedback;
use App\Http\Services\QiniuService;
use Illuminate\Http\Request;

class FeedbackController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Feedback $feedback,Request $request)
    {
        $where = [];
        $input = $request->all();
        if (!empty($input['keyword'])) $where[] = ['content','like',"%{$input['keyword']}%"];
        if (!empty($input['start'])) $where[] = ['created_at','>',$input['start'].' 00:00:00'];
        if (!empty($input['end'])) $where[] = ['created_at','<=',$input['end'].' 23:59:59'];
        $list = $feedback->where($where)->orderBy('created_at','desc')->paginate(10);
        return view('Admin.Feedback.index')->with(compact('list','input'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Feedback $feedback)
    {
        $data = $feedback->findOrFail($id);
        return view('Admin.Feedback.create')->with(compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QiniuService $qiniuService,Feedback $feedback)
    {
        $feedback = $feedback->findOrFail($request->id);
        if ($request->file('image'))
        {
            $file = $request->file('avatar');
            $feedback->image = $qiniuService->upload($file);
        }
        $feedback->position = $request->position;
        $feedback->title = $request->title;
        $feedback->sub_title = $request->sub_title;
        $feedback->url = $request->url;
        $feedback->sort = $request->sort;
        $feedback->status = $request->status == 'on' ? 1 : 0;
        $res = $feedback->save();
        if ($res)
        {
            $alert = ['success','操作成功'];
        }else {
            $alert = ['error','操作失败'];
        }
        return redirect('/Admin/Feedback/index')->with('alert',$alert);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Feedback $feedback)
    {
        $res = $feedback->destroy($id);
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
