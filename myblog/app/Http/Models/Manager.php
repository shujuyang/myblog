<?php

namespace App\Http\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

/*
 *  Manager  管理员模型
 *  该模型同时兼顾 用户名 和 密码 校验工作，
 **/
class Manager extends Authenticatable
{
       // 声明成员变量
    protected $table = 'manager';   // 设置表名
    protected $primaryKey = 'mg_id';// 设置主键
    // 限制 通过form 表单修改的字段，只有如下字段允许被修改
    protected $fillable = ['username','password','mg_role_ids','mg_pic','mg_sex','mg_phone','mg_email','mg_remark'];

    // 实现软删除
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    // 将 Manager 管理员模型 与 Role 角色 模型 建立关系
    public function role(){
        return $this->hasOne('App\Http\Models\Role','role_id','mg_role_ids');
    }
}
