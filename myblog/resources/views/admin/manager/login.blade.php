@extends('/admin/layout/layout')
@section('content')


  @parent
<link href="/admin/static/h-ui.admin/css/H-ui.login.css" rel="stylesheet" type="text/css" />

<input type="hidden" id="TenantId" name="TenantId" value="" />
<div class="header"></div>
<div class="loginWraper">
  <style type="text/css">
    .msg {
      height: 33px;
      line-height: 33px;
      background-color: pink;
      text-align: center;
    }
  </style>
  <div id="loginform" class="loginBox">
    @if(count($errors)>0)
      <div class="msg" style="opacity: 1">
      @if($msg = $errors->first('errorinfo'))
          {{ $msg }}
      @endif
      @if($msg = $errors->first('username'))
          {{ $msg }}&nbsp;&nbsp;
      @endif
      @if($msg = $errors->first('password'))
          {{ $msg }}&nbsp;&nbsp;
      @endif
      @if($msg = $errors->first('captcha_code'))
        {{ $msg }}&nbsp;&nbsp;
      @endif
      </div>
    @else
      <div class="msg" style="opacity: 0">
      </div>
    @endif

    <form class="form form-horizontal" id="form" action="/index.php/admin/manager/login" method="post">
      {{csrf_field()}}
      <div class="row cl">
        <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
        <div class="formControls col-xs-8">
          <input id="username" name="username" value="{{ old('username') }}" type="text" placeholder="账户" class="input-text size-L" autofocus>
        </div>
      </div>
      <div class="row cl">
        <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
        <div class="formControls col-xs-8">
          <input id="password" name="password" type="password" value="{{ old('password') }}" placeholder="密码" class="input-text size-L">
        </div>
      </div>
      <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
          <input name="captcha_code" id="captcha_code" class="input-text size-L" type="text" placeholder="验证码" style="width:150px;">
          <img id="captcha" src="{{captcha_src()}}" onclick=changeImg()> <a id="kanbuq" onclick=changeImg() href="javascript:;">看不清，换一张</a> </div>
      </div>
      <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
          <label for="online">
            <input type="checkbox" name="online" id="online" value="">
            使我保持登录状态</label>
        </div>
      </div>
      <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
          <input id="loginBtn" type="submit" class="btn btn-success radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
          <input id="resetBtn" type="reset" class="btn btn-default radius size-L" value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">
        </div>
      </div>
    </form>
  </div>
</div>
<div class="footer">后台管理系统</div>
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/admin/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript">
    function changeImg(){
        document.getElementById('captcha').src="{{captcha_src()}}?"+Math.random();
    }

    $(function(){
        $("#form").submit(function(){
            if($("#captcha_code").val().length != 5 ){
                $(".msg")[0].style={"opacity":1};
                $(".msg").html("请正确填写验证码");
                return false;
            }
        });

        $("#captcha_code").keyup(function(event){
            if($(this).val().length == 5){
                checkCaptcha();
            }
        });

        function checkCaptcha(){
            // 获取值，并发送ajax请求到服务器，检查验证码是否真确
            var value = $("#captcha_code").val();
            //console.log(value);
            if(value == "") return false;
            $.ajax({
                type : 'post',
                headers : {
                    'X-CSRF-TOKEN' : "{{ csrf_token() }}"
                },
                data : {'captchaValue' : value},
                dataType : 'jsonp',
                url  : '/index.php/admin/manager/captcha',
                success : function(data){
                    if(data == 1){
                        $("#loginBtn").removeAttr("disabled");
                        $(".msg")[0].style={"opacity":0};
                        console.log('ok');
                    }else{
                        $(".msg")[0].style={"opacity":1};
                        $(".msg")
                            .html("<b>{{Session::get('error0')}}</b>");
                        $("#loginBtn").attr("disabled","true");
                        console.log('no');
                    }
                }
            });
        }
    });
    $(function() {
       $.ajax({
           url: 'admin/index/index',
           type: 'get',
           success : function (e) {
               console.log(e)
           }
       })
    });
</script>
@endsection