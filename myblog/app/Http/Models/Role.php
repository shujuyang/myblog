<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/*
 *   Role 角色的模型类
 * */
class Role extends Model
{
    protected $table = 'role';  // 设置表名
    protected $primaryKey = 'role_id';  // 设置主键

    // 限定表中可以被修改的字段
    protected $fillable = ['role_name','role_permission_ids','role_permission_ac'];

    // 建立 Role 角色模型 与 Manager 管理员模型的关系  --  一对多
    public function manager(){
        return $this->hasMany('App\Http\Models\Manager','mg_role_ids','role_id');
    }

    // 建立 Role 角色模型 与 Permission 权限模型的管理 -- 一对多
    public function permission(){
        return $this->hasMany('App\Http\Models\Permission','ps_id','role_auth_ids');
    }

}