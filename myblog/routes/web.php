<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Home\IndexController@index');
Route::get('home/articleList/{list_name}','Home\ArticleController@getList');
Route::get('home/articleInfo/{ar_id}','Home\ArticleController@getInfo');


/*********设置url前缀 和 命名空间前缀 的路由群组**********/
Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){
    Route::match(['get','post'],"manager/login","ManagerController@login")->name('login');
    Route::post('manager/captcha','ManagerController@captcha');


    /***************验证管理员是否登录的路由群组***************/
    Route::group(['middleware'=>['auth:admin']],function(){
        Route::get("/a","IndexController@index");
        Route::get("index/index","IndexController@index");
        Route::get("index/welcome","IndexController@welcome");
        Route::get('manager/quit','ManagerController@quit');


        /** *******RBAC 后台分权限管理中间件 的路由群组******************/
        Route::group(['middleware'=>'RBAC'],function(){
            /**************管理员管理*************/
            Route::get("manager/showlist","ManagerController@showlist");
            Route::match(['get','post'],'manager/add','ManagerController@add');
            Route::post("manager/del/{manager}","ManagerController@del");
            Route::post('manager/up_pic','ManagerController@up_pic');
            Route::post("manager/stop/{manager}","ManagerController@stop");
            Route::post("manager/startUsing/{manager}","ManagerController@startUsing");
            Route::match(['get','post'],'manager/update/{mg_id}','ManagerController@update');

            /**************角色管理**************/
            Route::match(['get','post'],'role/showlist','RoleController@showlist');
            Route::match(['get','post'],'role/add','RoleController@add');
            Route::match(['get','post'],'role/update/{role_id}','RoleController@update');
            Route::post('role/del/{role_id}','RoleController@del');

            /**************权限管理**************/
            Route::get('permission/showlist','PermissionController@showlist');
            Route::match(['get','post'],'permission/add','PermissionController@add');
            Route::post('permission/del/{ps_id}','PermissionController@del');
            Route::match(['get','post'],'permission/update/{ps_id}','PermissionController@update');


            /**************文章管理*************/
            Route::match(['get','post'],'article/showlist','ArticleController@showlist');
            Route::match(['get','post'],'article/add','ArticleController@add');
            Route::post("article/del/{ar_id}","ArticleController@del");
            Route::match(['get','post'],'article/update/{ar_id}','ArticleController@update');
            Route::match(['get','post'],'article/fileUp','ArticleController@fileUp');
            Route::get('student/getExcel','StudentController@getExcel');

            /**************标签管理*************/
            Route::get('tag/showlist','TagController@showlist');
            Route::match(['get','post'],'tag/add','TagController@add');
            Route::post('tag/del/{tag_id}','TagController@del');
            Route::match(['get','post'],'tag/update/{tag_id}','TagController@update');

            /**************栏目管理************/
            Route::get('column/showlist','ColumnController@showlist');
            Route::match(['get','post'],'column/add','ColumnController@add');
            Route::post('column/del/{col_id}','ColumnController@del');
            Route::match(['get','post'],'column/update/{col_id}','ColumnController@update');

            /**************广告管理************/
            Route::get('advertisement/showlist','AdvertisementController@showlist');
            Route::get('advertisement/add','AdvertisementController@add');
            Route::post('advertisement/up_pic','AdvertisementController@up_pic');


            /************学生信息管理***********/
            Route::match(['get','post'],'student/showlist','StudentController@showlist');
            Route::match(['get','post'],'student/update/{st_id}','StudentController@update');
            Route::post('student/del/{st_id}','StudentController@del');

        });
    });
});

