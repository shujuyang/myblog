<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    // showlist()   学生列表显示
    public function showlist(Request $request) {
        if($request->isMethod('post')){
            //① 负责帮组datatable获得数据
            //获得纪录总条数
            $cnt = Student::count();

            //获得课时列表信息
            //【实现排序】，获得排序的条件， order by 字段 asc/desc
            $n = $request->input('order.0.column');         //字段序号
            $order = $request->input('columns.'.$n.'.data'); //获得排序字段
            $by = $request->input('order.0.dir');               //顺序

            //【实现分页】
            $offset = $request->input('start');
            $len = $request->input('length');

            //【检索模糊查找】
            $search = $request->input('search.value');

            $info = Student::orderBy($order,$by)->offset($offset)->limit($len)->
            where('st_username','like',"%$search%")
                ->with('regType')
                ->get();

            foreach($info as $student){
                if(empty($student->st_register_type)){
                    $info->reg_type = ['reg_name'=>''];
                }
            }

            //把$info数据传递给客户端的datatable使用
            return [
                'draw'=>$request->get('draw'),
                'recordsTotal'=>$cnt,
                'recordsFiltered'=>$cnt,
                'data'=>$info,
            ];
        }else {
            return view ('admin/student/showlist');
        }
    }

    // del()  删除指定id 的student
    public function del(Request $request) {
        $result = Student::where('st_id',$request->st_id)->delete();
        if($result){
            return json_encode(['result'=>true]);
        }else {
            return json_encode(['result'=>false]);
        }
    }

    // update() 修改student 信息
    public function update (Request $request) {
        if($request->isMethod('post')){

        }else {
            $student = Student::where('st_id',$request->st_id)->first();
            $regTypes = RegType::select('reg_id','reg_name')->get();
            dd($student);
            return view('/admin/student/update',compact('student','regTypes'));
        }
    }

    // getExcel()   生成Excel
    public function getExcel (Request $request) {
        $title = [
            ['序号','姓名','电话','邮箱','报考类型','来自页面','提交时间']
        ];
        $students = Student::select('st_id','st_username','st_phone','st_email','st_register_type','add_from','created_at')
            ->with('regType')->get()->all();
        foreach($students as $k=>$v){
            $students[$k]['st_register_type'] = $v['regType']['reg_name'];
            $students[$k] = $v->toArray();
            array_splice($students[$k],7,1);
        }

        $students = array_merge($title,$students);

        \Excel::create('学生列表',function($excel) use ($students){

            $excel->sheet('score', function($sheet) use ($students){
                $sheet->setWidth(array(
                    'A'     =>  5,
                    'B'     =>  10,
                    'C'     =>  20,
                    'D'     =>  20,
                    'E'     =>  20,
                    'F'     =>  20,
                    'G'     =>  20
                ));
                $sheet->rows($students);
            });
        })->download('xls');
    }
}
