@extends('admin/layout/layout')
@section('content')


    <article class="page-container">
        <form action="" method="post" class="form form-horizontal" id="form-admin-role-add">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>权限名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" placeholder="请输入权限名称" id="ps_name" name="ps_name" value="{{$permission->ps_name}}" />
                </div>
            </div>


            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">上级权限：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width:150px;">
			        <select class="select" name="ps_pid" size="1">
                        <option value="0" {{ $permission->ps_id==0? "selected='selected'":"" }}>顶级权限</option>
                        @foreach($psNames as $psName)
                                <option value="{{ $psName->ps_id }}" {{ $psName->ps_id==$permission->ps_pid?"selected='selected'":"123"}} >{{ $psName->ps_name }}</option>
                        @endforeach
			        </select>
			        </span>
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>控制器：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" placeholder="请输入控制器名称" id="ps_c" name="ps_c" value="{{ $permission->ps_c }}" />
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>控制器：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" placeholder="请输入方法名称" id="ps_a" name="ps_a" value="{{ $permission->ps_a }}" />
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>访问地址：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" placeholder="请输入访问地址" id="address" name="address" value="{{ $permission->address }}" />
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">权限等级：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width:150px;">
			        <select class="select" name="ps_level" size="1">
                        <option value="0" {{ $permission->ps_level==0 ? "selected='selected'":"" }} >1级权限</option>
                        <option value="1" {{ $permission->ps_level==1 ? "selected='selected'":"" }} >2级权限</option>
                        <option value="2" {{ $permission->ps_level==2 ? "selected='selected'":"" }} >3级权限</option>

			        </select>
			        </span>
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
        $(function() {
            //form表单提交数据存储
            $('#form-admin-role-add').submit(function(evt){
                evt.preventDefault();//阻止浏览器默认submit动作

                var shuju = $(this).serialize();

                //走ajax提交给服务器端
                $.ajax({
                    url:'{{url("/admin/permission/update/".$permission->ps_id)}}',
                    data:shuju,
                    headers:{
                        'X-CSRF-TOKEN':"{{csrf_token()}}",
                    },
                    dataType:'json',
                    type:'post',
                    success:function(msg){
                        if(msg.result===true){
                            layer.alert('添加成功',function(){
                                parent.window.location.href = parent.window.location.href; //刷新父页面
                                layer_close(); //关闭本身弹层
                            });
                        }else{
                            layer.alert('添加失败！【'+msg.errorinfo+'】',{'icon':5});
                        }
                    }
                });
            });
        });
    </script>
    <!--/请在上方写此页面业务相关的脚本-->
@endsection