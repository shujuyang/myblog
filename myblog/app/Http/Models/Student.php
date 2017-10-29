<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/*
 *  Student 学生模型类
 * */
class Student extends Model
{

    protected $table = 'student';
    protected $promaryKey = 'st_id';

    protected $fillable = ['st_username','st_phone','st_email','st_register_type','add_from'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    // 将学生与报考类型建立关联
    public function regType() {
        return $this->hasOne('App\Http\Models\RegType','reg_id','st_register_type');
    }
}
