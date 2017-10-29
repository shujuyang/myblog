<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Advertisement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdvertisementController extends Controller
{
    //showlist() 展示广告列表
    public function showlist (Request $request){
        $advertisements = Advertisement::get();
        return view ('admin/advertisement/showlist',compact('advertisements'));
    }

    // add()  添加广告
    public function add(Request $request) {
        if($request->isMethod('post')){

        }else {
            return view ('admin/advertisement/add');
        }
    }

    // up_pic() 方法 ， 长传附件
    public function up_pic(Request $request)
    {
        // 接受附件并存储到服务器上
        $file = $request->file('Filedata'); // 文件流
        if($file -> isValid()){
            $filename = $file -> store('advertisement','public');
            echo json_encode(['success'=>true,'filename'=>'/storage/'.$filename]);
        }else{
            echo json_encode(['success'=>false]);
        }
        exit;
    }
}
