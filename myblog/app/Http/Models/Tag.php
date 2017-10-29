<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/*
 * 这是 Tag 文章标签表模型
 * */
class Tag extends Model
{
    protected $table = 'tag';    // 模型类所对应的表
    protected $primaryKey = 'tag_id';    // 设置主键

    // 限定可以被修改的字段
    protected $fillable = ['tag_name'];

    // 设置软删除
    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
