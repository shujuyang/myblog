<?php

namespace App\Http\Controllers\Home;

use App\Http\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{

    public function index (Request $request) {
        return view ('home/index/index');
    }

    public function articleList (Request $request) {
        $articles = Article::select('ar_id','ar_title','ar_desc','img_path','ar_column_id','created_at')
                             ->OrderBy('created_at','desc')
                             ->limit(6)
                             ->with('column')
                             ->get();
        return ['result'=>'true','articles'=>$articles];
    }
}
