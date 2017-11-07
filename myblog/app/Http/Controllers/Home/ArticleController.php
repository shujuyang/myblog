<?php

namespace App\Http\Controllers\Home;

use App\Events\PostViewCount;
use App\Http\Models\Article;
use App\Http\Models\Column;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class ArticleController extends Controller
{

    const modelCacheExpires = 10;

    public function getList ( Request $request) {
        return view ('home/article/articleList');
    }

    /**/
    public function getInfo(Request $request) {
        return view ('home/article/articleInfo');
    }

    public function articleInfo (Request $request,$id){

        //Redis缓存中没有该post,则从数据库中取值,并存入Redis中,该键值key='post:cache'.$id生命时间10分钟
        $post = Cache::remember('post:cache:'.$id, self::modelCacheExpires, function () use ($id) {
            return Article::where('ar_id',$id)->first();
        });

        //获取客户端IP
        $ip = $request->ip();
//        dd($ip);
        //触发浏览量计数器事件
        event(new PostViewCount($post, $ip));

//        return view('test', compact('post'));

        $count = Redis::get('post:view:'.$ip);

        $article = Article::select('ar_id','ar_title','ar_editor','ar_tag_name','ar_column_id','ar_content','created_at')
                            ->with('tag')
                            ->with('column')
                            ->where('ar_id',$request->article)
                            ->first();
        return ['result'=>true,'article'=>$article,'count'=>$count];
    }

    public function articleList (Request $request) {
        $columnId = Column::select('col_id')->where('col_name',$request->column)->first();

        $articles = Article::select('ar_id','ar_title','ar_column_id','ar_desc','img_path','created_at','view_count','favorite_count','comment_count')
                            ->with('column')
                            ->where('ar_column_id',$columnId->col_id)
                            ->orderBy('created_at','desc')
                            ->limit(7)
                            ->get();
        return ['result'=>true,'articles'=>$articles];
    }


    public function articleListByView (Request $request) {
        $articles = Article::select('ar_id','ar_title')->orderBy('view_count','desc')->limit(6)->get();
        return ['result'=>true,'articlesView'=>$articles];
    }

    public function articleListByNew (Request $request) {
        $articles = Article::select('ar_id','ar_title')->orderBy('created_at','desc')->limit(6)->get();
        return ['result'=>true,'articlesView'=>$articles];
    }

}
