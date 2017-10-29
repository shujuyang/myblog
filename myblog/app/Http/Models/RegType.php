<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/*
 * RegType  报考类型模型类
 * */
class RegType extends Model
{
    protected $table = 'regType';    // 模型类所对应的表
    protected $primaryKey = 'reg_id';    // 设置主键

    // 限定可以被修改的字段
    protected $fillable = ['reg_name'];

    // 设置软删除
    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
