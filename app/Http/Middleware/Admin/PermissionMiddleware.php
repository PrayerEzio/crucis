<?php
/**
 * Copyright (c) 2018. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace App\Http\Middleware\Admin;

use App\Http\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $route = $this->getCurrentRoute();
        $permission_route_mca = "{$route['module']}-{$route['controller']}-{$route['action']}";
        $permission_route_mc = "{$route['module']}-{$route['controller']}-*";
        $permission_route_m = "{$route['module']}-*";
        $permission_route = "*";
        $admin_id = $request->session()->get('admin_info.id');
        if (empty($admin_id))
        {
            return abort(401, "Can't find the admin info.");
        }
        if ($this->hasPermission($admin_id,$permission_route))
        {
            return $next($request);
        }
        if ($this->hasPermission($admin_id,$permission_route_m))
        {
            return $next($request);
        }
        if ($this->hasPermission($admin_id,$permission_route_mc))
        {
            return $next($request);
        }
        if ($this->hasPermission($admin_id,$permission_route_mca))
        {
            return $next($request);
        }
        return abort(401, "Don't have [{$permission_route_mca}] permission");
    }

    protected function getCurrentRoute()
    {
        $route['route'] = Route::currentRouteAction();
        $route_array = explode('\\',$route['route']);
        $c_a = $route_array[count($route_array)-1];
        list($route['controller'],$route['action']) = explode('@',$c_a);
        $route['module'] = count($route_array) == 5 ? $route_array[3] : '';
        return $route;
    }

    protected function hasPermission($admin_id,$permission)
    {
        $admin = Admin::find($admin_id);
        $permission_model = new Permission();
        $permission_info = $permission_model->where(['name' => $permission])->first();
        if (empty($permission_info))
        {
            return false;
        }
        return $admin->hasPermissionTo($permission_info);
    }
}
