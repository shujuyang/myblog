<?php

namespace App\Http\Controllers\Home;

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
}
