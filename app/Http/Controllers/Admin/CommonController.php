<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Models\Admin;
use App\Http\Models\Message;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;

abstract class CommonController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    //基类构造函数
    public function __construct()
    {
        parent::__construct();
//        $message = new Message();
//        $this->message_list = $message->getLatestMessage(1,25);
    }

    protected function getAdminId()
    {
        return session('admin_info.id');
    }

    protected function getToken()
    {
        return session('_token');
    }

    //获取请求的方法
    protected function requestMethod()
    {
        $request = new Request();
        return strtoupper($request->thod());
    }

    protected function hasPermission($admin_id,$permission)
    {
        $admin = Admin::find($admin_id);
        return $admin->hasPermissionTo($permission);
    }

}
