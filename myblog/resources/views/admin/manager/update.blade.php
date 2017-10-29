@extends('admin/layout/layout')
@section('content')


<article class="page-container">
	<form class="form form-horizontal" id="form-admin-add">
	{{csrf_field()}}
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>管理员：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" value="{{$manager->username}}" placeholder="" id="username" name="username" readonly>
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>性别：</label>
		<div class="formControls col-xs-8 col-sm-9 skin-minimal">
			<div class="radio-box">
				<input name="mg_sex" type="radio" id="sex-1" value="男" {{  $manager->mg_sex=='男'?"checked='checked'":"" }}>
				<label for="sex-1">男</label>
			</div>
			<div class="radio-box">
				<input name="mg_sex" type="radio" id="sex-2" value="女" {{ $manager->mg_sex=='女'?"checked='checked'":"" }}>
				<label for="sex-2">女</label>
			</div>
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>手机：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" value="{{ $manager->mg_phone }}" placeholder="" id="mg_phone" name="mg_phone">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>邮箱：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" placeholder="@" name="mg_email" id="mg_email" value="{{ $manager->mg_email }}">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">角色：</label>
		<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
			<select class="select" name="mg_role_ids" size="1">
			@foreach($roles as $k=>$v)
					<option value="{{$v->role_id}}" {{ $v->role_id==$manager->mg_role_ids ? "selected='selected'":"" }}>{{$v->role_name}}</option>
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
	    // 阻止form表单的自动提交
		evt.preventDefault();
		// 获取数据
		var formData = $(this).serialize();
	    // 发送ajax请求
		$.ajax({
			type : "post",
			url  : "/admin/manager/update/{{$manager->mg_id}}",
			data : formData,
			dataType: 'json',
			success : function(data){
			    if(data.result === true){
			        // 修改成功
					layer.alert('修改成功',function(){
					    parent.window.location.href = parent.window.location.href;
					    layer_close();
					});
				}else{
                    var errors = data.info;
//			        console.log(errors);
					layer.alert('修改失败'+errors);
				}
			}
		});
	});
});
</script> 
<!--/请在上方写此页面业务相关的脚本-->
@endsection