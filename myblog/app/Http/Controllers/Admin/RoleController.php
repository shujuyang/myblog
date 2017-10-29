<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Permission;
use App\Http\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

/*
 *  这是 Role 角色 的控制器
 * */
class RoleController extends Controller
{

    // showlist() 方法，显示管理员角色列表的方法
    public function showlist(Request $request)
    {
        if ($request->isMethod('post')) {
            //dd($request->draw);
            // 获取datatables 所需要的数据
            /*
             * datatables 需要哪些数据？
             *  'draw'      这是 标记
             *   'recordsTotal' => $cnt,
             *   'recordsFiltered' => $cnt,
             *   'data' => $info
             * */
            $draw = $request->draw;

            // 获取数据表中的数据总数
            $count = \DB::table('role')->count();
            // 实现排序，获取排序所需的条件
            // 获取排序的字段号
            $n = $request->input('order.0.column');
            // 根据排序的字段号，获取排序的字段
            $order = $request->input('columns.' . $n . '.data');
            // 获取排序方式（升序 或 降序）
            $by = $request->input('order.0.dir');

            // 实现分页
            $offset = $request->input('start');
            $len = $request->input('length');

            // 实现检索的模糊查找
            $search = $request->input('search.value');

            // 根据请求的要求（排序、分页、模糊查询）获取数据
            $info = Role::orderBy($order, $by)
                ->offset($offset)->limit($len)
                ->where('role_name', 'like', "%$search%")
                ->orWhere('role_permission_ac', 'like', "%$search%")
                ->with('permission')
                ->get();
            // 将数据传递给视图层
            return [
                'draw' => $draw,
                'recordsTotal' => $count,
                'recordsFiltered' => $count,
                'data' => $info
            ];
        }
        return view('/admin/role/index');
    }

    // add() 方法 ， 添加角色的方法
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            // post方式提交，说明是添加表单提交的数据
            /*
             * 我需要做什么呢？
             *      A. 获取表单提交的数据
             *      B.使用Validator 进行数据校验
             *      C.如果数据没有问题，则将数据添加进数据库
             * */
            // 获取表单提交数据
            $role = $request->all();
            $role_name = $role['role_name'];
            $role_permission_ids = implode(',', $role['quanxian']);

            // 使用Validator 进行数据校验
            // 设计校验规则
            $roles = [
                'role_name' =>  'required',
                'role_name' =>  'unique:role,role_name',
                'quanxian'  =>  'required',
            ];

            $notices = [
                'role_name.required' => '角色名称不能为空',
                'role_name.unique'   => '改角色名称已存在',
                'quanxian.required'  => '权限不能为空',
            ];

            // 使用Validator 制作验证
            $validator = Validator::make($role,$roles,$notices);

            if($validator->passes()){
                // 获取role_permission_ac 的值
                // 获取permission 表中所有的数据
                $permissions = Permission::get();

                // 我要将 $permissions 集合中 ， 对应 $role['quanxian'] 中的 记录的 ps_c  和  ps_a 取出来
                $permissionsId = $permissions->pluck('ps_id');
                $role_permission_ac = "";
                foreach($permissionsId as $ps_id){
                    foreach($permissions as $permission){
                        if($permission->ps_id == $ps_id && $permission->ps_pid != 0){
                            $role_permission_ac .= $permission->ps_c."-".$permission->ps_a.",";
                        }
                    }
                }
                $role_permission_ac = rtrim($role_permission_ac,',');

                // 将数据添加到数据库
                $roleFromPost = new Role();
                $roleFromPost->role_name = $role_name;
                $roleFromPost->role_permission_ids = $role_permission_ids;
                $roleFromPost->role_permission_ac = $role_permission_ac;

                $roleFromPost->save();
                return json_encode(['result'=>true]);
            }else {
                // 没有通过验证
                $str = "";
                foreach($validator->errors()->all() as $k => $v){
                    $str .= $v.'，';
                }
                $str = rtrim($str,'，');
                return json_encode(['result'=>false,'errors'=>$str]);
            }

        }
            // 从权限表中获取权限相关的数据
            $permissionA = Permission::where('ps_level', '=', '0')->get();
            $permissionB = Permission::where('ps_level', '>', '0')->get();
            //dd($permissions);
            return view('/admin/role/add', compact('permissionA', 'permissionB'));
    }

    // del() 方法， 删除角色的方法
    public function del(Request $request) {
        $result = Role::where('role_id',$request->role_id)->delete();
        if($result){
            return json_encode(['result'=>true]);
        }else {
            return json_encode(['result'=>false]);
        }
    }

    // update() 方法， 修改角色的方法
    public function update(Request $request) {
        if($request->isMethod('post')){
// 获取表单提交数据
            $role = $request->all();
            $role_name = $role['role_name'];
            $role_permission_ids = implode(',', $role['quanxian']);

            // 使用Validator 进行数据校验
            // 设计校验规则
            $roles = [
                'role_name' =>  'required',
                'role_name' =>  'unique:role,role_name',
                'quanxian'  =>  'required',
            ];

            $notices = [
                'role_name.required' => '角色名称不能为空',
                'role_name.unique'   => '改角色名称已存在',
                'quanxian.required'  => '权限不能为空',
            ];

            // 使用Validator 制作验证
            $validator = Validator::make($role,$roles,$notices);

            if($validator->passes()){
                // 获取role_permission_ac 的值
                // 获取permission 表中所有的数据
                $permissions = Permission::get();

                // 我要将 $permissions 集合中 ， 对应 $role['quanxian'] 中的 记录的 ps_c  和  ps_a 取出来
                $permissionsId = $permissions->pluck('ps_id');
                $role_permission_ac = "";
                foreach($permissionsId as $ps_id){
                    foreach($permissions as $permission){
                        if($permission->ps_id == $ps_id && $permission->ps_pid != 0){
                            $role_permission_ac .= $permission->ps_c."-".$permission->ps_a.",";
                        }
                    }
                }
                $role_permission_ac = rtrim($role_permission_ac,',');

                // 将数据添加到数据库
                $roleFromPost = Role::where('role_id',$request->role_id)->first();
                $roleFromPost->role_name = $role_name;
                $roleFromPost->role_permission_ids = $role_permission_ids;
                $roleFromPost->role_permission_ac = $role_permission_ac;

                $roleFromPost->save();
                return json_encode(['result'=>true]);
            }else {
                // 没有通过验证
                $str = "";
                foreach($validator->errors()->all() as $k => $v){
                    $str .= $v.'，';
                }
                $str = rtrim($str,'，');
                return json_encode(['result'=>false,'errors'=>$str]);
            }
        }else {
            // 从权限表中获取权限相关的数据
            $permissionA = Permission::where('ps_level', '=', '0')->get();
            $permissionB = Permission::where('ps_level', '>', '0')->get();
            $role = Role::where('role_id',$request->role_id)->first();

            return view('admin/role/update',compact('permissionA','permissionB','role'));
        }
    }
}
