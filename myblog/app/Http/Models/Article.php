<?php

namespace App\Http\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
/*
 *  Article  文章模型
 **/
class Article extends Authenticatable
{
    // 声明成员变量
    protected $table = 'article';   // 设置表名
    protected $primaryKey = 'ar_id';// 设置主键
    // 限制 通过form 表单修改的字段，只有如下字段允许被修改
    protected $fillable = ['ar_title','ar_editor','ar_content','ar_desc','ar_tag_name','ar_column_id','is_new','is_hot','is_top'];

    // 实现软删除
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    // 将 Article 文章模型 与 Tag 标签模型 建立关系
    public function tag(){
        return $this->hasMany('App\Http\Models\Tag','tag_id','ar_tag_name');
    }

    public function column () {
        return $this->hasMany('App\Http\Models\Column','col_id','ar_column_id');
    }
}
