<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/*
 *   这是 Permission 权限模型类
 * */
class Permission extends Model
{
    protected $table = 'permission';    // 模型类所对应的表
    protected $primaryKey = 'ps_id';    // 设置主键

    // 限定可以被修改的字段
    protected $fillable = ['ps_name','ps_pid','ps_c','ps_a','address','ps_level'];

    // 设置软删除
    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
