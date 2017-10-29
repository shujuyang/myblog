<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Manager;
use App\Http\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ManagerController extends Controller
{
    // login() 方法 ， 后台管理员登录的页面
    public  function login(Request $request){

        if($request->isMethod('post')){
            // 实现表单数据的简单验证
            // 制定规则，规定username和password为必填项
            $rules = [
                'username' => 'required',
                'password' => 'required',
                //'captcha_code' => 'required|captcha',
            ];
            // 制定错误提示
            $notices = [
                'username.required' => '用户名必须填写',
                'password.required' => '密码必须填写',
                //'captcha_code.required' => '验证码必填',
                //'captcha_code.captcha'  => '验证码不正确',
            ];
            // 使用Validator 制作验证
            $validator = Validator::make($request->all(),$rules,$notices);
            // 查看验证是否通过
            if($validator->passes()){
                // 获取数据
                $username = $request->input('username');
                $password = $request->input('password');
                // 登录方法 Auth::attempt()
                if(Auth::guard('admin')->attempt(['username'=>$username,'password'=>$password])){
                    if(Manager::select('is_ok')->where('username',$username)->first()->is_ok == '是') {
                        return redirect('admin/index/index');
                    }
                }else{
                    return redirect('admin/manager/login')
                        ->withErrors(['errorinfo'=>'用户名或密码有误'])
                        ->withInput();
                }
            }else{
                return redirect('admin/manager/login')
                    ->withErrors($validator)
                    ->withInput();
            }
        }else{
            return view("/admin.manager.login");
        }
    }

    // captcha() 方法 ， 检验 验证码是否正确的方法
    public function captcha(Request $request)
    {
        // file_put_contents('./test.doc',$request->all());
        // 获取数据
        // file_put_contents('./test.doc',$value);
        // 进行验证码的 验证
        // 制定验证规则
        $rules = ['captchaValue' => 'required|captcha'];
        // 制定错误提示
        $notices = [
            'captchaValue.required' => '验证码必填',
            'captchaValue.captcha'  => '验证码不正确',
            //'captcha_code.size' => '验证码不能为空',
        ];
        // 使用Validator 制作验证
        $validator = Validator::make($request->all(),$rules,$notices);
        // 查看验证是否通过
        if ($validator->passes()) {
            // 通过验证了
            return 1;
        } else {
            // 没有通过验证
            $arr = $validator->errors()->all();
            foreach($arr as $k=>$v){
                Session::put('error'.$k,$v);
            }
            return 0;
        }
    }

    // quit() 方法 ， 后台管理员退出登录的方法
    public function quit(Request $request)
    {

        // 管理员退出登录，也就是将session 中存储id 的信息删除掉就可以了
        //$data = $request->session()->all();
        $result = Auth::guard('admin')->logout();
        return redirect('/admin/manager/login');
    }


    // showlist() 方法 ， 后台显示管理员列表的方法
    /*
     * 先去数据库去数据，再将数据返回给view 展示
     * */
    public function showlist() {
        // 主动的方法获取数据
        $info = Manager::with('role')->paginate(3);
        return view("/admin/manager/showlist",['info'=> $info]);
    }


    //add() 方法 ， 后台添加管理员的方法
    /*
     * 添加管理员的方法，这个方法分为get和post两种请求方式，
     *      get请求下，显示添加管理员的页面
     *      post请求下，接收请求数据，将其添加到数据库中
     * */
    public function add(Request $request) {
        if($request->isMethod('post')){
            // 接收数据，except('_token') 方法，是将除 _token之外的请求数据进行接收
            $requestData = $request->except('_token');
            // 对数据进行验证
            // 制作验证规则
            $roles = [
                'username' =>   'required|unique:manager',
                'password' =>   'required|min:4',
                'password_confirmation' => 'required|same:password',
                'mg_role_ids'=> 'required',
            ];

            // 制定错误提示
            $notices = [
                'username.required' =>  '用户名不能为空',
                'username.unique'   =>  '用户名已存在',
                'password.required' =>  '密码不能为空',
                'password.min'      =>  '密码不能少于四位',
                'password_confirmation.required' =>  '确认密码不能为空',
                'password_confirmation.same' =>  '两次输入的密码不同',

                'mg_role_ids.required'          =>  '用户角色不能为空'
            ];

            // 使用Validator 制作验证
            $validator = Validator::make($requestData,$roles,$notices);

            // 判断验证是否通过
            if($validator->passes()){
                // 通过验证
                // 将数据添加到数据库中
                // 将密码加密
                $requestData['password'] = bcrypt($requestData['password']);
                if(Manager::create($requestData)){
                    echo json_encode(['result'=>true]);
                }else{ file_put_contents('./test.doc',"no");
                    echo json_encode(['result'=>false]);
                }
            }else{
                // 没有通过验证
                $str = "";
                foreach($validator->errors()->all() as $k => $v){
                    $str .= $v.'，';
                }
                $str = rtrim($str,'，');
                echo json_encode(['result'=>false, 'info'=>$str]);
            }
        }else {
            $roles = Role::all();
            return view("/admin/manager/add",compact('roles'));
        }


    }

    // update() 方法 ， 修改管理员信息的方法
    /*
     *  这是一个修改管理员信息的方法，在对更新的数据插入到数据库之前，我需要对数据进行验证
     * */

    public function update(Request $request){
        $manager = Manager::where('mg_id',$request->mg_id)->first();
        if($request->isMethod('post')){
            $dataRequest = $request->all();
            // 对数据进行验证
            // 制作验证规则
            // 制定规则
            $roles = [
                'username' =>   'required|unique:manager,username,'.$request->input('mg_id').',mg_id',
                'username' =>   'required',
                'mg_role_ids'=> 'required',
            ];

            // 制定错误提示
            $notices = [
                'username.required' =>  '用户名不能为空',
                'username.unique'   =>  '用户名已存在',
                'mg_role_ids.required'          =>  '用户角色不能为空'
            ];

            // 使用Validator 制作验证
            $validator = Validator::make($dataRequest,$roles,$notices);
            if($validator->passes()){
                // 通过验证
                $result = $manager->update($dataRequest);

                if($result){
                    echo json_encode(['result'=>true]);
                }else{
                    echo json_encode(['result'=>false,'info'=>'数据修改失败']);
                }
            }else{
                // 没有通过验证
                // 没有通过验证
                $str = "";
                foreach($validator->errors()->all() as $k => $v){
                    $str .= $v.'，';
                }
                $str = rtrim($str,'，');

                echo json_encode(['result'=>false,'info'=>$str]);
            }

        }else{
            $roles = Role::all();
            return view('/admin/manager/update',compact('manager','roles'));
        }
    }

    // del() 方法 ， 删除管理员信息的方法
    public function del(Request $request ,Manager $manager){
        if($manager->delete()){
            return 1;   // 成功
        }else{
            return 0;   // 失败
        }
    }

    //stop() 方法 ， 停用管理员账户的方法
    /*
     * 停用管理员的账户，其实就是更改记录的 is_ok 字段 为 "否"
     * */
    public  function stop(Request $request,Manager $manager){
        //file_put_contents('./test.doc',$manager->mg_id);
        // 到数据库中修改字段
        $manager->is_ok = '否';
        if($manager->save()){
            // 修改成功
            // 将$manager的mg_id 通过session传递到视图
            return json_encode(['result'=>true,'mg_id'=>$manager->mg_id]);
        }else{
            // 修改失败
            //file_put_contents('./test.doc','not ok');
            return json_encode(['result'=>false]);
        }
    }


    // startUsing() 方法 ， 启用管理员账户的方法
    public function startUsing(Request $request,Manager $manager){
        // 到数据库中修改数据
        $manager->is_ok = '是';
        if($manager->save()){
            // 修改成功了
            return json_encode(['result'=>true,'mg_id'=>$manager->mg_id]);
        }else {
            return json_encode(['result'=>false]);
        }
    }

    // up_pic() 方法 ， 管理员上传头像的方法
    public function up_pic(Request $request)
    {
        // 接受附件并存储到服务器上
        $file = $request->file('Filedata'); // 文件流
        if($file -> isValid()){
            $filename = $file -> store('manager','public');
            echo json_encode(['success'=>true,'filename'=>'/storage/'.$filename]);
        }else{
            echo json_encode(['success'=>false]);
        }
        exit;
    }
}
