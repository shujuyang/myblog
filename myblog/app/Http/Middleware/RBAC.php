<?php

namespace App\Http\Middleware;

use Closure;


class RBAC
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //dd(\Route::current()->getActionName());
        // 获取当前登录的管理员的信息
        $admin_id = \Auth::guard('admin')->user()->mg_id;
        $admin_name = \Auth::guard('admin')->user()->username;

        // 非 snow（超级管理员） 的用户 才需要进行翻墙访问的校验
        if($admin_name != 'snow'){
            // 判断 当前登录的 管理员是否有权访问当前请求
            // A. 获取当前请求的 “控制器-操作方法”
            $action = \Route::current()->getActionName();
            list($class, $method) = explode('@', $action);
            $array = explode('\\',$class);
            $controllerName = explode('Controller',$array[count($array)-1])[0];

            $nowCA = $controllerName."-".$method;

            // B.获取当前管理员所具备的访问权限
            $roleinfo = \DB::table('manager as m')
                ->join('role as r','r.role_id','=','m.mg_role_ids')
                ->where('m.mg_id',$admin_id)
                ->select('r.role_permission_ac')
                ->first();

            // 提取 具备的权限（控制器-操作方法）
            $haveCA = $roleinfo->role_permission_ac;

            // C.判断 $nowCA 在 $havaCA 中存不存在，
            // 存在，则放行；不存在，则停止程序
            if(strpos($haveCA,$nowCA) === false){
                exit('您没有访问权限');
            }
        }
        // 放行
        return $next($request);
    }
}
