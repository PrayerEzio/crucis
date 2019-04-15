<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Admin;
use App\Http\Models\User;
use App\Http\Services\AdminService;
use App\Http\Services\QiniuService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthController extends CommonController
{
    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function admin_list(Admin $admin)
    {
        $admin_list = $admin->paginate(12);
        return view('Admin.Auth.admin_list')->with(compact('admin_list'));
    }

    public function permission_list(Permission $permission)
    {
        $permission_list = $permission->get();
        return view('Admin.Auth.permission_list')->with(compact('permission_list'));
    }

    public function role_list(Role $role)
    {
        $role_list = $role->paginate(12);
        return view('Admin.Auth.role_list')->with(compact('role_list'));
    }

    public function admin_show($id,Admin $admin,Role $role)
    {
        $admin_info = $admin->findOrFail($id);
        $role_list = $role->all();
        return view('Admin.Auth.admin_show')->with(compact('admin_info','role_list'));
    }

    public function admin_store($id, Request $request, QiniuService $qiniuService, AdminService $adminService, Admin $admin)
    {
        $adminService->edit($id,$request,$qiniuService);
        $admin_info = $admin->findOrFail($id);
        $role_list = $admin_info->getRoleNames();
        if (!empty($role_list->toArray())) {
            foreach ($role_list as $item)
            {
                $admin_info->removeRole($item);
            }
        }
        if (!empty($request->role)) $admin_info->syncRoles($request->role);
        $alert = ['success','操作成功'];
        return redirect(config('crucis.app_url') . '/Admin/Auth/admin_list')->with('alert', $alert);
    }

    public function permission_create(Request $request,Permission $permission)
    {
        if ($request->isMethod('post'))
        {
            $permission->name = $request->name;
            $permission->guard_name = 'web';
            $permission->display_name = $request->display_name;
            $permission->description = $request->description;
            $res = $permission->save();
            if ($res)
            {
                $alert = ['success','操作成功'];
            }else {
                $alert = ['error','操作失败'];
            }
            return redirect(config('crucis.app_url') . "/Admin/Auth/permission_list")->with('alert', $alert);
        }else {
            return view('Admin.Auth.permission_create');
        }
    }

    public function permission_edit(Request $request,Permission $permission)
    {
        if ($request->isMethod('post'))
        {
            $permission = $permission->findOrFail($request->id);
            $permission->name = $request->name;
            $permission->guard_name = 'web';
            $permission->display_name = $request->display_name;
            $permission->description = $request->description;
            $res = $permission->save();
            if ($res)
            {
                $alert = ['success','操作成功'];
            }else {
                $alert = ['error','操作失败'];
            }
            return redirect(config('crucis.app_url') . "/Admin/Auth/permission_list")->with('alert', $alert);
        }else {
            $data = $permission->findOrFail($request->id);
            return view('Admin.Auth.permission_create')->with(compact('data'));
        }
    }

    public function permission_delete(Request $request,Permission $permission)
    {
        $res = $permission->destroy($request->id);
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

    public function role_create(Request $request,Role $role,Permission $permission)
    {
        if ($request->isMethod('post'))
        {
            $role->name = $request->name;
            $role->guard_name = 'web';
            $role->display_name = $request->display_name;
            $role->description = $request->description;
            $res = $role->save();
            $role->givePermissionTo($request->permission);
            if ($res)
            {
                $alert = ['success','操作成功'];
            }else {
                $alert = ['error','操作失败'];
            }
            return redirect(config('crucis.app_url') . "/Admin/Auth/role_list")->with('alert', $alert);
        }else {
            $permission_list = $permission->all();
            return view('Admin.Auth.role_create')->with(compact('permission_list'));
        }
    }

    public function role_edit(Request $request,Role $role,Permission $permission)
    {
        if ($request->isMethod('post'))
        {
            $role = $role->findOrFail($request->id);
            $role->name = $request->name;
            $role->guard_name = 'web';
            $role->display_name = $request->display_name;
            $role->description = $request->description;
            $res = $role->save();
            $role->revokePermissionTo($permission->all());
            $role->givePermissionTo($request->permission);
            if ($res)
            {
                $alert = ['success','操作成功'];
            }else {
                $alert = ['error','操作失败'];
            }
            return redirect(config('crucis.app_url') . "/Admin/Auth/role_list")->with('alert', $alert);
        }else {
            $permission_list = $permission->all();
            $data = $role->findOrFail($request->id);
            return view('Admin.Auth.role_create')->with(compact('data','permission_list'));
        }
    }

    public function role_delete(Request $request,Role $role)
    {
        $res = $role->destroy($request->id);
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