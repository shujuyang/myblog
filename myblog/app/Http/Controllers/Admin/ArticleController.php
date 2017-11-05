<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Models\Article;
use App\Http\Models\Column;
use App\Http\Models\Student;
use App\Http\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class ArticleController extends ApiController
{
    //showlist() 方法，后台显示文章列表
    public function showlist (Request $request) {
        if($request->isMethod('post'))
        {
            //① 负责帮组datatable获得数据
            //获得纪录总条数
            $cnt = Article::count();

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

            $articles = Article::orderBy($order,$by)->offset($offset)->limit($len)->
            where('ar_title','like',"%$search%")
                ->with('tag')
                ->with('column')
                ->get();
            // 数据处理
            foreach($articles as $article) {
                $article->ar_content = mb_substr(rtrim($article->ar_content),0,50);
                $article->ar_desc = mb_substr(rtrim($article->ar_content),0,40);
            }

            //把$info数据传递给客户端的datatable使用
            return [
                'draw'=>$request->get('draw'),
                'recordsTotal'=>$cnt,
                'recordsFiltered'=>$cnt,
                'data'=>$articles,
            ];
        }else{
            return view('admin/article/showlist');
        }
    }

    // add() 方法，后台添加文章
    public function add (Request $request) {
        if($request->isMethod('post')){
            // post提交，获取数据，验证数据，数据入库
            // 接受数据
            $article = $request->except('_token');
            //dd($article);
            // 标签实体化
            //$article['ar_content'] = htmlentities($article['ar_content']);
            // 验证数据
            // 制作验证规则
            $roles = [
                'ar_title' =>   'required',
                'ar_editor' =>   'required',
                'ar_tag_name'=> 'required',
                'ar_column_id' => 'required',
            ];

            // 制定错误提示
            $notices = [
                'ar_title.required' =>  '文章标题不能为空',
                'ar_editor.required' =>  '编辑者不能为空',
                'ar_tag_name.required' =>  '文章所属标签不能为空',
                'ar_column_id.required' =>  '文章所属栏目不能为空',
            ];

            // 使用Validator 制作验证
            $validator = Validator::make($article,$roles,$notices);
            $article['ar_tag_name'] = implode(',',$article['ar_tag_name']);
            $article['ar_column_id'] = implode(',',$article['ar_column_id']);
            // 判断验证是否通过
            if($validator->passes()){
                // 通过验证
                // 将数据添加到数据库中
                Article::create($article);
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
            $tag = Tag::select('tag_id','tag_name')->get();
            $column = Column::select('col_id','col_name')->get();
            return view ('admin/article/add',compact('tag','column'));
        }
    }

    // getById()  获取指定id的文章
    public function getById (Request $request , Article $article) {
        return view();
    }

    // del() 删除指定id的文章
    public function del(Request $request) {
        $result = Article::where('ar_id',$request->ar_id)->delete();
        if($result){
            return json_encode(['result'=>true]);
        }else {
            return json_encode(['result'=>false]);
        }
    }

    public function update(Request $request) {

        if($request->isMethod('post')){
            $article = $request->except('_token');
            $article['ar_id'] = $request->ar_id;
            //dd($article);
            $roles = [
                'ar_title' =>   'required',
                'ar_editor' =>   'required',
                'ar_tag_name'=> 'required',
                'ar_column_id' => 'required',
            ];

            // 制定错误提示
            $notices = [
                'ar_title.required' =>  '文章标题不能为空',
                'ar_editor.required' =>  '编辑者不能为空',
                'ar_tag_name.required' =>  '文章所属标签不能为空',
                'ar_column_id.required' =>  '文章所属栏目不能为空',
            ];


            $article['ar_tag_name'] = implode(',',$article['ar_tag_name']);
            $article['ar_column_id'] = implode(',',$article['ar_column_id']);
            // 使用Validator 制作验证
            $validator = Validator::make($article,$roles,$notices);
            // 判断验证是否通过
            if($validator->passes()){
                // 通过验证
                // 将数据添加到数据库中
                $oldArticle = Article::where('ar_id',$request->ar_id)->first();
                $oldArticle->update($article);

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
            $article = Article::where('ar_id',$request->ar_id)->first();
            $tag = Tag::select('tag_id','tag_name')->get();
            $column = Column::select('col_id','col_name')->get();
            return view('admin/article/update',compact('article','tag','column'));
        }
    }

    /*
     * fileUp()  文件上传
     * */
    public function fileUp (Request $request) {
        if($request->isMethod('get')){
            return view ('admin/article/fileUp');
        }else{
            //接收附件并存储到服务器上
            $file = $request->file('Filedata');  //文件流
            if($file->isValid()){
                $filename = $file -> store('article');
                echo json_encode(['success'=>true,'filename'=>"http://www.shujuyang.cn/home/article/downfile/".$filename]);
            }else{
                echo json_encode(['success'=>false]);
            }
            exit;//避免后续输出信息
        }
    }
}