<?php

namespace App\Http\Controllers\Home;

use App\Http\Models\Article;
use App\Http\Models\Column;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    //
    public function getList ( Request $request) {
        return view ('home/article/articleList');
    }

    /**/
    public function getInfo(Request $request) {
        return view ('home/article/articleInfo');
    }

    public function articleInfo (Request $request){
        $article = Article::select('ar_id','ar_title','ar_editor','ar_tag_name','ar_column_id','ar_content','created_at')
                            ->with('tag')
                            ->with('column')
                            ->where('ar_id',$request->article)
                            ->first();
        return ['result'=>true,'article'=>$article];
    }

    public function articleList (Request $request) {
        $columnId = Column::select('col_id')->where('col_name',$request->column)->first();

        $articles = Article::select('ar_id','ar_column_id','ar_desc','created_at')
                            ->with('column')
                            ->where('ar_column_id',$columnId->col_id)
                            ->orderBy('created_at','desc')
                            ->limit(7)
                            ->get();
        return ['result'=>true,'articles'=>$articles];
    }
}
