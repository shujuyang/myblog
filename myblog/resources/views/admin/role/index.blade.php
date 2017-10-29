@extends('admin/layout/layout')
@section('content')
	@yield('title','角色管理')

<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 角色中心 <span class="c-gray en">&gt;</span> 角色管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="text-c"> 日期范围：
		<input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
		-
		<input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" class="input-text Wdate" style="width:120px;">
		<input type="text" class="input-text" style="width:250px" placeholder="输入会员名称、电话、邮箱" id="" name="">
		<button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜角色</button>
	</div>
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a href="javascript:;" onclick="member_add('添加角色','{{url("admin/role/add")}}','','510')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加角色</a></span> </div>
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<th width="6%"><input type="checkbox" name="" value=""></th>
				<th width="6%">ID</th>
				<th width="15%">角色名称</th>
				<th width="25%">对应权限ids</th>
				<th width="25%">权限方法</th>
				<th width="13%">创建时间</th>
				<th width="*">操作</th>
			</tr>

		</thead>

	</table>
	</div>
</div>


<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/admin/static/h-ui/js/H-ui.min.js"></script> 
<script type="text/javascript" src="/admin/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script> 
<script type="text/javascript" src="/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">

    $(function(){
        $('.table-sort').dataTable({
            "order": [[ 1, "desc" ]],//默认第几个排序
            "stateSave": false,//状态保存
            "columnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {"orderable":false,"targets":[0,6]}// 制定列不参与排序
            ],
            'lengthMenu' : [3,6,9],
            'paging'	 : true,
            'info'		 : true,
            'searching'	 : true,
            'ordering'	 : true,
            'processing' : true,
            'serverSide' : true,
            //'scrollY': 400,
            'ajax'  	 : {
                'url' : "/admin/role/showlist",
                'type': 'post',
                'headers' : {
                    'X-CSRF-TOKEN' : '{{csrf_token()}}'
                },
            },
            // 给各个 'td' 填充内容
            'columns' : [
                {'data' : 'a','defaultContent':"<input type='checkbox'>"},
                {'data' : 'role_id'},
                {'data' : 'role_name'},
                {'data' : 'role_permission_ids'},
                {'data' : 'role_permission_ac'},
                {'data' : 'created_at'},
                {'data' : 'b','defaultContent':"",'className': 'td_manager'},
            ],
            "createdRow" : function(row,data,dataIndex){
                // 该方法会遍历每个新生成的tr
console.log(data)
                // 此处，可以对生成好的tr、td进行二次优化，改造
                // row：就是生成的tr的dom对象，设置为$(row) 就变成 jquery对象
                // data: 服务器端传递过来的每条 数据记录
                // dataIndex：是tr的下标索引号码
				// 将表格中的数据居中显示
				$(row).children('td').css('text-align','center');

                // 给最后的 td 设置功能按钮
                var btn = '<a title="修改" href="javascript:;" onclick="member_edit(\'修改\',\'/admin/role/update/'+data.role_id+'\',800,510)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a><a title="删除" href="javascript:;" onclick="member_del(this,'+data.role_id+')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>';
                $(row).find('td:eq(6)').html(btn);

                // 给 tr 设置class 属性
                $(row).addClass('text-c');
            }
        });
    });

/*角色-添加*/
function member_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*角色-查看*/
function member_show(title,url,id,w,h){
	layer_show(title,url,w,h);
}
/*角色-编辑*/
function member_edit(title,url,w,h){
	layer_show(title,url,w,h);
}
/*密码-修改*/
function change_password(title,url,id,w,h){
	layer_show(title,url,w,h);	
}
/*角色-删除*/
function member_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'POST',
			url: '/admin/role/del/'+id,
			dataType: 'json',
            headers : {
                'X-CSRF-TOKEN' : '{{csrf_token()}}'
            },
			success: function(data){
				$(obj).parents("tr").remove();
				layer.msg('已删除!',{icon:1,time:1000});
			},
			error:function(data) {
				console.log(data.msg);
			},
		});		
	});
}
</script> 
@endsection