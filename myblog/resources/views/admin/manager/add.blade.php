@extends('/admin/layout/layout')
@section('content')


<article class="page-container">
	<form class="form form-horizontal" id="form-admin-add">
	{{csrf_field()}}

	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>管理员：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" value="" placeholder="" id="username" name="username">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>初始密码：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="password" class="input-text" autocomplete="off" placeholder="密码" id="password" name="password">
		</div>
	</div>

	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>确认密码：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="password" class="input-text" autocomplete="off"  placeholder="确认新密码" id="password_confirmation" name="password_confirmation">

		</div>
	</div>

	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>性别：</label>
		<div class="formControls col-xs-8 col-sm-9 skin-minimal">
			<div class="radio-box">
				<input name="mg_sex" type="radio" id="sex-1" value="男" checked>
				<label for="sex-1">男</label>
			</div>
			<div class="radio-box">
				<input name="mg_sex" type="radio" value="女" id="sex-2">
				<label for="sex-2">女</label>
			</div>
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>手机：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" value="" placeholder="" id="mg_phone" name="mg_phone">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>邮箱：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" placeholder="@" name="mg_email" id="mg_email">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">角色：</label>
		<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
			<select class="select" name="mg_role_ids" size="1">
			@foreach($roles as $k=>$v)
				<option value="{{$v->role_id}}">{{$v->role_name}}</option>
				@endforeach
			</select>
			</span>
		</div>
	</div>

	<div class="row cl">
		<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
			<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
		</div>
	</div>
	</form>
</article>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/admin/static/h-ui/js/H-ui.min.js"></script> 
<script type="text/javascript" src="/admin/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->


<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script> 
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script> 
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script> 
<script type="text/javascript">
$(function(){
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	});
	//给添加form表单设置submit事件
	$('#form-admin-add').submit(function(evt){
		//ajax方式提交form表单信息给服务器
		evt.preventDefault();//组织浏览器form表单提交
		var shuju = $(this).serialize();
		//执行ajax
		$.ajax({
			url:'/admin/manager/add',
			data:shuju,
			dataType:'json',
			type:'post',
			success:function(data){
			    //alert(data);
				if(data.result === true){
					// 添加数据成功
					layer.alert('添加成功',function(){
					    parent.window.location.href = parent.window.location.href;
					   	// 关闭当前添加页面
					     layer_close();
					});
				}else{
					// 添加数据失败
					// 获取错误信息
					var errors = data.info;
					layer.alert(errors,{icon:5});
                }
			}

		});
	});
});
</script> 
<!--/请在上方写此页面业务相关的脚本-->
@endsection