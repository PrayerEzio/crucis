<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Album;
use App\Http\Models\AlbumPicture;
use App\Http\Models\AlbumPicturePicture;
use App\Http\Services\QiniuService;
use Illuminate\Http\Request;

class AlbumPictureController extends CommonController
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Album $album)
    {
        $where[] = ['is_private','<>',1];
        $albums_list = $album->where([
            ['is_private','=',1],
            ['admin_id',$this->getAdminId()]
        ])->orWhere([
            ['is_private','=',0]
        ])->orderBy('sort','desc')->get();
        return view('Admin.AlbumPicture.create')->with(compact('albums_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,AlbumPicture $albumPicture,QiniuService $qiniuService)
    {
        if ($request->file('picture'))
        {
            $file = $request->file('picture');
            $albumPicture->picture = $qiniuService->upload($file);
        }else {
            return redirect()->back()->withInput()->withErrors('请上传相片！');
        }
        $albumPicture->album_id = $request->album_id;
        $albumPicture->title = $request->title;
        $albumPicture->sub_title = $request->sub_title;
        $res = $albumPicture->save();
        if ($res)
        {
            $alert = ['success','操作成功'];
            return redirect(config('crucis.app_url') . "/Admin/Album/{$albumPicture->album_id}")->with('alert', $alert);
        }else {
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(AlbumPicture $albumPicture,$id,Album $album)
    {
        $where[] = ['is_private','<>',1];
        $albums_list = $album->where([
            ['is_private','=',1],
            ['admin_id',$this->getAdminId()]
        ])->orWhere([
            ['is_private','=',0]
        ])->orderBy('sort','desc')->get();
        $data = $albumPicture->findOrFail($id);
        return view('Admin.AlbumPicture.create')->with(compact('data','albums_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AlbumPicture $albumPicture, QiniuService $qiniuService)
    {
        $albumPicture = $albumPicture->findOrFail($request->id);
        if ($request->file('picture'))
        {
            $file = $request->file('picture');
            $albumPicture->picture = $qiniuService->upload($file);
        }
        $albumPicture->album_id = $request->album_id;
        $albumPicture->title = $request->title;
        $albumPicture->sub_title = $request->sub_title;
        $res = $albumPicture->save();
        if ($res)
        {
            $alert = ['success','操作成功'];
            return redirect(config('crucis.app_url') . "/Admin/Album/{$albumPicture->album_id}")->with('alert', $alert);
        }else {
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id,AlbumPicture $albumPicture)
    {
        $res = $albumPicture->destroy($request->id);
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
