<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    // showlist() 显示标签列表
    public function showlist (Request $request) {
        $tags = Tag::get();

        return view ('/admin/tag/showlist',compact('tags'));
    }

    // add() 添加标签
    public function add (Request $request) {
        if($request->isMethod('post')){
            $tag_name = ['tag_name'=>$request->input('tag_name')];
            // 验证数据
            // 制作验证规则
            $roles = [
                'tag_name' =>   'required',
            ];

            // 制定错误提示
            $notices = [
                'tag_name.required' =>  '标签名不能为空',
            ];

            // 使用Validator 制作验证
            $validator = \Validator::make($tag_name,$roles,$notices);
            // 判断验证是否通过
            if($validator->passes()){
                // 通过验证
                // 将数据添加到数据库中
                Tag::create($tag_name);
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
            return view('/admin/tag/add');
        }
    }

    // del()  删除指定id 的标签
    public function del (Request $request) {
        $result = Tag::where('tag_id',$request->tag_id)->delete();
        if($result){
            return json_encode(['result'=>true]);
        }else {
            return json_encode(['result'=>false]);
        }
    }

    // update() 编辑标签
    public function update (Request $request) {
        if($request->isMethod('post')){
            $tag_name = ['tag_name'=>$request->input('tag_name')];
            // 验证数据
            // 制作验证规则
            $roles = [
                'tag_name' =>   'required',
            ];

            // 制定错误提示
            $notices = [
                'tag_name.required' =>  '标签名不能为空',
            ];

            // 使用Validator 制作验证
            $validator = \Validator::make($tag_name,$roles,$notices);
            // 判断验证是否通过
            if($validator->passes()){
                // 通过验证
                // 将数据添加到数据库中
                if(Tag::where('tag_id',$request->tag_id)->first()->update($tag_name)){
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
            $tag = Tag::where('tag_id',$request->tag_id)->first();
            return view('admin/tag/update',compact('tag'));
        }
    }
}
