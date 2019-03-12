<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Services\QiniuService;
use Illuminate\Http\Request;

class UploadController extends BaseController
{
    /**
     * 通用上传
     *
     * 通用上传接口
     *
     * @Post("/upload")
     * @Versions({"v1"})
     * @Request(headers={"Authorization": "Bearer+token"})
     * @Parameters({
     *     @Parameter("file", description="上传的文件",required=true),
     * })
     * @Transaction({
     *     @Response(200, body={"status_code":500,"message":"{error_message}"}),
     *     @Response(200, body={"status_code":200,"message":"SUCCESS","data":{"upload_url":"{url}"}}),
     * })
     */
    public function index(Request $request,QiniuService $qiniuService)
    {
        if ($request->file('file'))
        {
            $result = $qiniuService->upload($request->file('file'));
            if ($result == false)
            {
                $response = [
                    "message" => "上传失败!",
                    "status_code" => 500,
                ];
            } else {
                $response = [
                    "data" => ['upload_url' => $result],
                    "message" => "SUCCESS",
                    "status_code" => 200,
                ];
            }
        } else {
            $response = [
                "message" => "上传失败!",
                "status_code" => 500,
            ];
        }
        return $this->response->array($response);
    }
}
