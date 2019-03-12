<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\SystemLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SystemLogController extends Controller
{
    public function index(Request $request,SystemLog $systemLog)
    {
        $where = [];
        $input = $request->all();
        !empty($input['keyword']) ? $where[] = ['title','like',"%{$input['keyword']}%"] : $input['keyword'] = '';
        !empty($input['start']) ? $where[] = ['created_at','>',$input['start'].' 00:00:00'] : $input['start'] = '';
        !empty($input['end']) ? $where[] = ['created_at','<=',$input['end'].' 23:59:59'] : $input['end'] = '';
        $list = $systemLog->where($where)->orderBy('id','desc')->paginate(10);
        return view('Admin.SystemLog.index')->with(compact('list','input'));
    }

    public function detail($id,Request $request,SystemLog $systemLog)
    {
        $data = $systemLog->findOrFail($id);
        if ($request->ajax()) {
            return response([
                'status'  => 200,
                'message' => __('Operation succeed.'),
                'data' => $data,
            ]);
        }
    }
}
