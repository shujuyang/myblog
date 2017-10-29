<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/*
 * Regulation  简章模型类
 * */
class Regulation extends Model
{
    protected $table = 'regulation';    // 模型类所对应的表
    protected $primaryKey = 'reg_id';    // 设置主键

    // 限定可以被修改的字段
    protected $fillable = ['reg_title','reg_content','reg_year','reg_filepath'];

    // 设置软删除
    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
