<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Advertisement;
use App\Http\Services\QiniuService;
use Illuminate\Http\Request;

class AdvertisementController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Advertisement $advertisement,Request $request)
    {
        $where = [];
        $input = $request->all();
        if (!empty($input['title'])) $where[] = ['title','like',"%{$input['title']}%"];
        if (!empty($input['position'])) $where[] = ['position','=',$input['position']];
        if (!empty($input['start'])) $where[] = ['created_at','>',$input['start'].' 00:00:00'];
        if (!empty($input['end'])) $where[] = ['created_at','<=',$input['end'].' 23:59:59'];
        $list = $advertisement->where($where)->orderBy('created_at','desc')->paginate(10);
        return view('Admin.Advertisement.index')->with(compact('list','input'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.Advertisement.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Advertisement $advertisement,QiniuService $qiniuService)
    {
        if ($request->file('image'))
        {
            $file = $request->file('image');
            $advertisement->image = $qiniuService->upload($file);
        }
        if (empty($advertisement->image))
        {
            $alert = ['error','图片地址不能为空!'];
            return redirect(config('crucis.app_url') . '/Admin/Advertisement/create')->with('alert', $alert);
        }
        $advertisement->position = $request->position;
        $advertisement->title = $request->title;
        $advertisement->sub_title = $request->sub_title;
        $advertisement->url = $request->url;
        $advertisement->sort = $request->sort;
        $advertisement->status = $request->status == 'on' ? 1 : 0;
        $res = $advertisement->save();
        if ($res)
        {
            $alert = ['success','操作成功'];
            return redirect(config('crucis.app_url') . '/Admin/Advertisement')->with('alert', $alert);
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
    public function edit($id,Advertisement $advertisement)
    {
        $data = $advertisement->findOrFail($id);
        return view('Admin.Advertisement.create')->with(compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, QiniuService $qiniuService,Advertisement $advertisement)
    {
        $advertisement = $advertisement->findOrFail($id);
        if ($request->file('image'))
        {
            $file = $request->file('image');
            $advertisement->image = $qiniuService->upload($file);
        }
        $advertisement->position = $request->position;
        $advertisement->title = $request->title;
        $advertisement->sub_title = $request->sub_title;
        $advertisement->url = $request->url;
        $advertisement->sort = $request->sort;
        $advertisement->status = $request->status == 'on' ? 1 : 0;
        $res = $advertisement->save();
        if ($res)
        {
            $alert = ['success','操作成功'];
        }else {
            $alert = ['error','操作失败'];
        }
        return redirect(config('crucis.app_url') . '/Admin/Advertisement')->with('alert', $alert);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Advertisement $advertisement)
    {
        $res = $advertisement->destroy($id);
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
