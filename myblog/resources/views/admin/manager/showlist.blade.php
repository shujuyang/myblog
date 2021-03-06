﻿@extends('/admin/layout/layout')
@section('content')


<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 管理员列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="text-c"> 日期范围：
		<input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
		-
		<input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" class="input-text Wdate" style="width:120px;">
		<input type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" id="" name="">
		<button type="submit" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
	</div>
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a href="javascript:;" onclick="admin_add('添加管理员','/admin/manager/add','800','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加管理员</a></span> <span class="r">共有数据：<strong>54</strong> 条</span> </div>
	<table class="table table-border table-bordered table-bg">
		<thead>
			<tr>
				<th scope="col" colspan="9">员工列表</th>
			</tr>
			<tr class="text-c">
				<th width="25"><input type="checkbox" name="" value=""></th>
				<th width="40">ID</th>
				<th width="150">登录名</th>
				<th width="90">手机</th>
				<th width="150">邮箱</th>
				<th>角色</th>
				<th width="130">加入时间</th>
				<th width="100">是否已启用</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
		{{--循环遍历从数据库中取出的数据--}}
		@foreach($info as $k=>$v)

		<tr class="text-c">
			<td><input type="checkbox" value="1" name=""></td>
			<td>{{ $v->mg_id }}</td>
			<td>{{ $v->username }}</td>
			<td>{{ $v->mg_phone }}</td>
			<td>{{ $v->mg_email }}</td>
			<td>{{ empty($v->role->role_name)? '' : $v->role->role_name }}</td>
			<td>{{ $v->created_at }}</td>
			<td class="td-status">
				@if($v->is_ok == '是')
					<span class="label label-success radius">已启用</span>
				@elseif($v->is_ok == '否')
					<span class="label label-default radius">已禁用</span>
				@endif

			</td>
			<td class="td-manage">
				@if($v->is_ok == '是')
					<a style="text-decoration:none" onClick="admin_stop(this,'{{  $v->mg_id }}')" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a>
				@elseif($v->is_ok == '否')
					<a onClick="admin_start(this,'{{ $v->mg_id  }}')" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>
				@endif
				<a title="编辑" href="javascript:;" onclick="admin_edit('管理员编辑','/admin/manager/update/{{$v->mg_id}}','{{$v->mg_id}}','800','500')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:void(0);"  onclick="admin_del(this,'{{$v->mg_id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
			</td>
		</tr>
		@endforeach
		</tbody>
	</table>
	<link rel="stylesheet" href="/css/pagination.css">
	<div style="text-align: center;">{{$info->links()}}</div>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/admin/static/h-ui/js/H-ui.min.js"></script> 
<script type="text/javascript" src="/admin/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script> 
<script type="text/javascript" src="/admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
/*
	参数解释：
	title	标题
	url		请求的url
	id		需要操作的数据id
	w		弹出层宽度（缺省调默认值）
	h		弹出层高度（缺省调默认值）
*/
/*管理员-增加*/
function admin_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-删除*/
function admin_del(obj,id){
    // alert(obj);exit;
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'POST',
			url: '/admin/manager/del/'+id,
			headers : {
			    "X-CSRF-TOKEN" : "{{ csrf_token() }}"
			},
			dataType: 'json',
			success: function(data){
				$(obj).parents("tr").remove();
				layer.msg('已删除!',{icon:1,time:1000});
			},
			error:function(data) {
//				console.log(data.msg);
			},
		});		
	});
}

/*管理员-编辑*/
function admin_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}
/*管理员-停用*/
function admin_stop(obj,id){
	layer.confirm('确认要停用吗？',function(index){
		//此处请求后台程序，下方是成功后的前台处理……
		$.ajax({
			type : 'post',
			data : {'mg_id':id},
			url  : '/admin/manager/stop/'+id,
			headers : {
                "X-CSRF-TOKEN" : "{{ csrf_token() }}"
			},

			success : function(data){
                data = JSON.parse(data);
			    if(data.result){
			        // 成功
                    $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_start(this,'+data.mg_id+')" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
                    //$(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_start(this,)" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
                    $(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">已禁用</span>');
                    $(obj).remove();
                    layer.msg('已停用!',{icon: 5,time:1000});
				}else{
                    layer.msg('停用失败!',{icon: 5,time:1000});
				}
			}
		});
	});
}

/*管理员-启用*/
function admin_start(obj,id){
	layer.confirm('确认要启用吗？',function(index){
		//此处请求后台程序，下方是成功后的前台处理……
        $.ajax({
            type : 'post',
            data : {'mg_id':id},
            url  : '/admin/manager/startUsing/'+id,
            headers : {
                "X-CSRF-TOKEN" : "{{ csrf_token() }}"
            },
            success : function(data){
                data = JSON.parse(data);
                if(data.result){
                    // 成功
                    $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_stop(this,'+data.mg_id+' )" href="javascript:;" title="停用" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
                    //$(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_stop(this, )" href="javascript:;" title="停用" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
                    $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
                    $(obj).remove();
                    layer.msg('已启用!', {icon: 6,time:1000});
                }else{
                    layer.msg('启用失败!',{icon: 5,time:1000});
                }
            }
        });
	});
}
</script>
@endsection