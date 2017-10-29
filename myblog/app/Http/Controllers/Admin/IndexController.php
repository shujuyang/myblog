<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    // index() 方法 ， 后台显示首页的方法
    public function index(){
        /*
         * 在index() 方法中，我要根据登录的管理员角色，获取他所拥有的权限
         *
         *  然后，根据具体权限，在index 页面中显示他锁能操作的功能
         * */
        // 获取当前登录系统的管理员的 所有的权限信息
        $mg_id = \Auth::guard('admin')->user()->mg_id;
        //dd($mg_id);
        $roleinfo = \DB::table('manager as m')
            ->join('role as r','m.mg_role_ids','r.role_id')
            ->select('role_permission_ids')
            ->where('mg_id',$mg_id)
            ->first();

        try{
            // 有正确分配角色的普通管理员
            $permission_ids = explode(',',$roleinfo->role_permission_ids);

            // 一级权限
            $permissionA = \DB::table('permission')
                -> whereIn('ps_id',$permission_ids)
                -> where('ps_level','0')
                -> get();
            // 二级权限
            $permissionB = \DB::table('permission')
                -> whereIn('ps_id',$permission_ids)
                -> where('ps_level','1')
                ->get();
        }catch (\Exception $e){
            if($mg_id == 1){
                // 超级管理员 snow ， 则拥有全部权限

                // 一级权限
                $permissionA = \DB::table('permission')
                    -> where('ps_level','0')
                    ->get()->toArray();

                // 二级权限
                $permissionB = \DB::table('permission')
                    -> where('ps_level','1')
                    ->get()->toArray();
            }else{
                // 为分配角色的普通管理员 （0个权限）
                $permissionA = [];
                $permissionB = [];
            }
        }
        return view("admin/index/index",compact('permissionA','permissionB'));
    }

    // welcome() 方法 ， 后台显示右侧欢迎页的方法
    public function welcome (){
        return view("admin.index.welcome");
    }
}
