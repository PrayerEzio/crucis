<?php
/**
 * Copyright (c) 2019. Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan. 
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna. 
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus. 
 * Vestibulum commodo. Ut rhoncus gravida arcu. 
 */

namespace App\Http\Controllers\Admin;

use App\Http\Models\Report;
use Illuminate\Http\Request;

class ReportController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Report $report,Request $request)
    {
        $where = [];
        $input = $request->all();
        if (!empty($input['keyword'])) $where[] = ['body','like',"%{$input['keyword']}%"];
        if (!empty($input['start'])) $where[] = ['created_at','>',$input['start'].' 00:00:00'];
        if (!empty($input['end'])) $where[] = ['created_at','<=',$input['end'].' 23:59:59'];
        if (!empty($input['category_id'])) $where[] = ['category_id',$input['category_id']];
        $list = $report->where($where)->orderBy('created_at','desc')->paginate(10);
        return view('Admin.Report.index')->with(compact('list','input'));
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
    public function edit($id,Report $report)
    {
        $data = $report->findOrFail($id);
        return view('Admin.Report.create')->with(compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Report $report)
    {
        $report = $report->findOrFail($request->id);
        $report->category_id = $request->category_id;
        $report->body = $request->body;
        $report->sort = $request->sort;
        $report->status = $request->status == 'on' ? 1 : 0;
        $res = $report->save();
        if ($res)
        {
            $alert = ['success','操作成功'];
        }else {
            $alert = ['error','操作失败'];
        }
        return redirect('/Admin/Report/index')->with('alert',$alert);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Report $report)
    {
        $res = $report->destroy($id);
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
