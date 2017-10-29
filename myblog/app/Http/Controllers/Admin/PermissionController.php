<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    //index() 方法  显示权限 列表的 方法
    public function showlist (Request $request){
        // 获取permission 表中的数据
        $permissionA = Permission::where('ps_pid','0')->get();
        $permissionB = Permission::where('ps_pid','!=','0')->get();

        return view('/admin/permission/index',compact('permissionA','permissionB'));
    }

    /*
     * add()  添加权限
     **/
    public function add (Request $request) {
        if($request->isMethod('post')){
            // 获取数据
            $permission = $request->except('_token');
            // 数据校验
            // 设计校验规则
            $roles = [
                'ps_name' =>  'required',
                'ps_pid'  =>  'required',
                'ps_c'    =>  'required',
                'ps_a'    =>  'required',
                'address' =>  'required',
                'ps_level'=>  'required'
            ];

            $notices = [
                'ps_name.required' => '权限名称不能为空',
//                'ps_name.unique'   => '权限名称已存在',
                'ps_pid.required'  => '父级权限不能为空',
                'ps_c.required'    => '控制器不能为空',
                'ps_a.required'    => '操作方法不能为空',
                'address.required' => '地址不能为空',
                'ps_level.required'=> '权限等级不能空'
            ];

            // 使用Validator 制作验证
            $validator = \Validator::make($permission,$roles,$notices);

            if($validator->passes()){
//                dd($permission);
                Permission::create($permission);
                return json_encode(['result'=>true]);
            }else {
                // 没有通过验证
                $str = "";
                foreach($validator->errors()->all() as $k => $v){
                    $str .= $v.'，';
                }
                $str = rtrim($str,'，');
                return json_encode(['result'=>false,'errorinfo'=>$str]);
            }
        }else {
            $permissions = Permission::select('ps_id','ps_name')->where('ps_level','0')->get();
            return view('admin/permission/add',compact('permissions'));
        }
    }

    public function del(Request $request) {
        $result = Permission::where('ps_id',$request->ps_id)->delete();
        if($result){
            return json_encode(['result'=>true]);
        }else {
            return json_encode(['result'=>false]);
        }
    }

    public function update (Request $request) {
        if($request->isMethod('post')){
            // 获取数据
            $permission = $request->except('_token');
            // 数据校验
            // 设计校验规则
            $roles = [
                'ps_name' =>  'required',
                'ps_pid'  =>  'required',
                'ps_c'    =>  'required',
                'ps_a'    =>  'required',
                'address' =>  'required',
                'ps_level'=>  'required'
            ];

            $notices = [
                'ps_name.required' => '权限名称不能为空',
//                'ps_name.unique'   => '权限名称已存在',
                'ps_pid.required'  => '父级权限不能为空',
                'ps_c.required'    => '控制器不能为空',
                'ps_a.required'    => '操作方法不能为空',
                'address.required' => '地址不能为空',
                'ps_level.required'=> '权限等级不能空'
            ];

            // 使用Validator 制作验证
            $validator = \Validator::make($permission,$roles,$notices);

            if($validator->passes()){
                if(Permission::where('ps_id',$request->ps_id)->first()->update($permission)){
                    return json_encode(['result'=>true]);
                }else {
                    return json_encode(['result'=>false,'info'=>'修改失败']);
                }
                return json_encode(['result'=>true]);
            }else {
                // 没有通过验证
                $str = "";
                foreach($validator->errors()->all() as $k => $v){
                    $str .= $v.'，';
                }
                $str = rtrim($str,'，');
                return json_encode(['result'=>false,'errorinfo'=>$str]);
            }

        }else {
            $permission = Permission::where('ps_id',$request->ps_id)->first();
            $psNames = Permission::select('ps_id','ps_name')->where('ps_level','0')->get();
            return view('admin/permission/update',compact('permission','psNames'));
        }
    }
}