<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/*
 * Advertisement  广告模型类
 * */
class Advertisement extends Model
{
    protected $table = 'advertisement';    // 模型类所对应的表
    protected $primaryKey = 'adv_id';    // 设置主键

    // 限定可以被修改的字段
    protected $fillable = ['adv_title','adv_path','adv_desc'];

    // 设置软删除
    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
