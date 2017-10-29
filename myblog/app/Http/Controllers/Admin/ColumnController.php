<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Column;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ColumnController extends Controller
{
    //showlist() 显示栏目列表
    public function showlist (Request $request) {
        $columns = Column::get();
        return view ('/admin/column/showlist',compact('columns'));
    }

// add() 添加标签
    public function add (Request $request) {
        if($request->isMethod('post')){
            $col_name = ['col_name'=>$request->input('col_name')];

            // 验证数据
            // 制作验证规则
            $roles = [
                'col_name' =>   'required',
            ];

            // 制定错误提示
            $notices = [
                'col_name.required' =>  '栏目名不能为空',
            ];

            // 使用Validator 制作验证
            $validator = \Validator::make($col_name,$roles,$notices);
            // 判断验证是否通过
            if($validator->passes()){
                // 通过验证
                // 将数据添加到数据库中
                Column::create($col_name);
                //dd($col_name);
                return json_encode(['result'=>true]);
            }else{
                // 没有通过验证
                $str = "";
                foreach($validator->errors()->all() as $k => $v){
                    $str .= $v.'，';
                }
                return json_encode(['result'=>false,'info'=>$str]);
            }

        }else {
            // get请求
            return view('/admin/column/add');
        }
    }



    // del()  删除指定id 的标签
    public function del (Request $request) {
        $result = Column::where('col_id',$request->col_id)->delete();
        if($result){
            return json_encode(['result'=>true]);
        }else {
            return json_encode(['result'=>false]);
        }
    }

    // update() 编辑标签
    public function update (Request $request) {
        if($request->isMethod('post')){
            $col_name = ['col_name'=>$request->input('col_name')];
            // 验证数据
            // 制作验证规则
            $roles = [
                'col_name' =>   'required',
            ];

            // 制定错误提示
            $notices = [
                'col_name.required' =>  '栏目名不能为空',
            ];

            // 使用Validator 制作验证
            $validator = \Validator::make($col_name,$roles,$notices);
            // 判断验证是否通过
            if($validator->passes()){
                // 通过验证
                // 将数据添加到数据库中
                if(Column::where('col_id',$request->col_id)->first()->update($col_name)){
                    return json_encode(['result'=>true]);
                }else {
                    return json_encode(['result'=>false,'info'=>'修改失败']);
                }
            }else{
                // 没有通过验证
                $str = "";
                foreach($validator->errors()->all() as $k => $v){
                    $str .= $v.'，';
                }
                return json_encode(['result'=>false,'info'=>$str]);
            }
        }else {
            //get 请求
            $column = Column::where('col_id',$request->col_id)->first();
            return view('admin/column/update',compact('column'));
        }
    }

}
