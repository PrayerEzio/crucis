<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Album;
use App\Http\Models\AlbumPicture;
use App\Http\Services\QiniuService;
use Illuminate\Http\Request;

class AlbumController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Album $album)
    {
        $where[] = ['is_private','<>',1];
        $list = $album->where([
            ['is_private','=',1],
            ['admin_id',$this->getAdminId()]
        ])->orWhere([
            ['is_private','=',0]
        ])->orderBy('sort','desc')->get();
        return view('Admin.Album.index')->with(compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.Album.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Album $album,QiniuService $qiniuService)
    {
        if ($request->file('image'))
        {
            $file = $request->file('image');
            $album->image = $qiniuService->upload($file);
        }
        $album->name = $request->name;
        $album->admin_id = $this->getAdminId();
        $album->sort = $request->sort;
        $album->is_private = $request->status == 'on' ? 1 : 0;
        $res = $album->save();
        if ($res)
        {
            $alert = ['success','操作成功'];
            return redirect('/Admin/Album')->with('alert',$alert);
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
    public function show($id,Album $album)
    {
        $data = $album->findOrFail($id);
        return view('Admin.Album.show')->with(compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Album $album,$id)
    {
        $data = $album->findOrFail($id);
        return view('Admin.Album.create')->with(compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Album $album, QiniuService $qiniuService)
    {
        $album = $album->findOrFail($request->id);
        if ($request->file('image'))
        {
            $file = $request->file('image');
            $album->image = $qiniuService->upload($file);
        }
        $album->name = $request->name;
        $album->admin_id = $this->getAdminId();
        $album->sort = $request->sort;
        $album->is_private = $request->status == 'on' ? 1 : 0;
        $res = $album->save();
        if ($res)
        {
            $alert = ['success','操作成功'];
        }else {
            $alert = ['error','操作失败'];
        }
        return redirect("/Admin/Album")->with('alert',$alert);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id,Album $album)
    {
        $res = $album->destroy($request->id);
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
