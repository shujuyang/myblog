<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Column
 * @package App\Http\Models
 *
 */
class Column extends Model
{
    protected $table = 'column';    // 模型类所对应的表
    protected $primaryKey = 'col_id';    // 设置主键

    // 限定可以被修改的字段
    protected $fillable = ['col_name'];

    // 设置软删除
    use SoftDeletes;
    protected $dates = ['deleted_at'];
}

