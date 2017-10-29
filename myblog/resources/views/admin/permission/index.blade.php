@extends('admin/layout/layout')
@section('content')
    @yield('title','权限管理')

    <style>
        .my-table tr td{
            text-align: center;
        }
    </style>
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 权限中心 <span class="c-gray en">&gt;</span> 权限管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <div class="text-c"> 日期范围：
            <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" class="input-text Wdate" style="width:120px;">
            <input type="text" class="input-text" style="width:250px" placeholder="输入会员名称、电话、邮箱" id="" name="">
            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜权限</button>
        </div>
        <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a href="javascript:;" onclick="member_add('添加权限','{{url("admin/permission/add")}}','','510')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加权限</a></span> <span class="r">共有数据：<strong>88</strong> 条</span> </div>

        <div class="mt-20">
            <table class="table table-border table-bordered table-hover table-bg table-sort my-table">
                <thead>
                <tr class="text-c">
                    <th width="6%"><input type="checkbox" name="" value=""></th>
                    <th width="6%">ID</th>
                    <th width="12%">权限名称</th>
                    <th width="6%">上级权限id</th>
                    <th width="12%">控制器</th>
                    <th width="12%">操作方法</th>
                    <th width="20%">url地址</th>
                    <th width="13%">创建时间</th>
                    <th width="*">操作</th>
                </tr>
                </thead>

                @foreach($permissionA as $permissiona)
                    <tr>
                        <td><input type="checkbox" name="" value=""></td>
                        <td>{{$permissiona->ps_id}}</td>
                        <td>{{$permissiona->ps_name}}</td>
                        <td>{{$permissiona->ps_pid}}</td>
                        <td>{{$permissiona->ps_c}}</td>
                        <td>{{$permissiona->ps_a}}</td>
                        <td>{{$permissiona->address}}</td>
                        <td>{{$permissiona->created_at}}</td>
                        <td><a title="修改" href="javascript:;" onclick="per_update('修改','/admin/permission/update/{{$permissiona->ps_id}}',800,510)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a><a title="删除" href="javascript:;" onclick="per_del(this,'{{ $permissiona->ps_id }}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                    </tr>
                    @foreach($permissionB as $permissionb)
                        @if($permissionb->ps_pid == $permissiona->ps_id)
                            <tr>
                                <td><input type="checkbox" name="" value=""></td>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;{{$permissionb->ps_id}}</td>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;{{$permissionb->ps_name}}</td>
                                <td>{{$permissionb->ps_pid}}</td>
                                <td>{{$permissionb->ps_c}}</td>
                                <td>{{$permissionb->ps_a}}</td>
                                <td>{{$permissionb->address}}</td>
                                <td>{{$permissionb->created_at}}</td>
                                <td><a title="修改" href="javascript:;" onclick="per_update('修改','/admin/permission/update/{{$permissionb->ps_id}}',800,510)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a><a title="删除" href="javascript:;" onclick="per_del(this, '{{ $permissionb->ps_id }}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                            </tr>
                        @endif
                    @endforeach


                    @endforeach


            </table>
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
        /*权限-添加*/
        function member_add(title,url,w,h){
            layer_show(title,url,w,h);
        }

        /*权限-编辑*/
        function per_update(title,url,w,h){
            layer_show(title,url,w,h);
        }
        /*密码-修改*/
        function change_password(title,url,id,w,h){
            layer_show(title,url,w,h);
        }
        /*权限-删除*/
        function per_del(obj,id){
            layer.confirm('确认要删除吗？',function(index){
                $.ajax({
                    type: 'POST',
                    url: '/admin/permission/del/'+id,
                    dataType: 'json',
                    headers:{
                        'X-CSRF-TOKEN':"{{csrf_token()}}",
                    },
                    success: function(data){
                        if(data.result){
                            $(obj).parents("tr").remove();
                            layer.msg('已删除!',{icon:1,time:1000});
                        }else {
                            layer.alert('删除失败！',{'icon':5});
                        }

                    },
                    error:function(data) {
                        console.log(data.msg);
                    },
                });
            });
        }
    </script>
@endsection