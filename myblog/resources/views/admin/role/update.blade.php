@extends('admin/layout/layout')
@section('content')
    @yield('title','角色添加')

    <article class="page-container">
        <form action="" method="post" class="form form-horizontal" id="form-admin-role-add">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" placeholder="请输入角色名称" id="role_name" name="role_name" value="{{ $role->role_name }}" />
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">操作权限：</label>
                <div class="formControls col-xs-8 col-sm-9">

                    @foreach($permissionA as $v)
                        <dl class="permission-list">
                            <dt>
                                <label>
                                    <input type="checkbox" value="{{$v->ps_id}}" name="quanxian[]" class="quanli" {{ array_search($v->ps_id,explode(',',$role->role_permission_ids))!== false ? "checked='checked'":"" }}/>
                                    {{$v->ps_name}}</label>
                            </dt>
                            <dd>
                                <dl class="cl permission-list2">
                                    <dd>
                                        @foreach($permissionB as $k=>$vv)
                                            @if($vv->ps_pid == $v->ps_id)
                                                <div>
                                                    <label class="">
                                                        <input type="checkbox" value="{{$vv->ps_id}}" name="quanxian[]" class="quanli" {{ array_search($vv->ps_id,explode(',',$role->role_permission_ids)) !== false ? "checked='checked'":"" }}/>
                                                        {{$vv->ps_name}}
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </dd>
                                </dl>
                            </dd>
                        </dl>
                    @endforeach

                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <button type="submit" class="btn btn-success radius" id="admin-role-save" name="admin-role-save"><i class="icon-ok"></i> 确定</button>
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
            //一级权限复选框点击事件操作(勾选则二级都勾选，取消二级页都取消)
            $(".permission-list dt input:checkbox").click(function(){
                $(this).closest("dl").find("dd input:checkbox").prop("checked",$(this).prop("checked"));
            });

            //每个一级权限下边的二级权限，如果有至少一个选中，则其对应的一级权限也要选中
            $(".permission-list2 dd input:checkbox").click(function(){
                var l =$(this).parent().parent().find("input:checked").length;
                var l2=$(this).parents(".permission-list").find(".permission-list2 dd").find("input:checked").length;
                if($(this).prop("checked")){
                    $(this).closest("dl").find("dt input:checkbox").prop("checked",true);
                    $(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",true);
                }
                else{
                    if(l==0){
                        $(this).closest("dl").find("dt input:checkbox").prop("checked",false);
                    }
                    if(l2==0){
                        $(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",false);
                    }
                }
            });

            //form表单提交数据存储
            $('#form-admin-role-add').submit(function(evt){
                evt.preventDefault();//阻止浏览器默认submit动作

                var shuju = $(this).serialize();//把form表单信息组织为“name=tom&age=21&addr=beijing”
                                                //该信息会把form表单“全部”表单域的信息都收集起来，包括"权限复选框"
                //如果没有给角色分配权限，则禁止动作
                if($('.quanli:checked').length<1){
                    layer.alert('请给当前角色分配权限',{'icon':5});
                    return false;
                }
                //走ajax提交给服务器端
                $.ajax({
                    url:"{{url('/admin/role/update/'.$role->role_id)}}",
                    data:shuju,
                    headers:{
                        'X-CSRF-TOKEN':"{{csrf_token()}}",
                    },
                    dataType:'json',
                    type:'post',
                    success:function(msg){
                        if(msg.result===true){
                            layer.alert('修改成功',function(){
                                parent.window.location.href = parent.window.location.href; //刷新父页面
                                layer_close(); //关闭本身弹层
                            });
                        }else{
                            layer.alert('修改失败！【'+msg.errorinfo+'】',{'icon':5});
                        }
                    }
                });
            });
        });
    </script>
    <!--/请在上方写此页面业务相关的脚本-->
@endsection