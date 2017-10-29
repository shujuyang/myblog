@extends('/admin/layout/layout')
@section('content')


    <article class="page-container">
        <form class="form form-horizontal" id="form-admin-add">
            {{csrf_field()}}

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3" style="width: 20%;"><span class="c-red">*</span>标签名：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" id="tag_name" name="tag_name" value="{{$tag->tag_name}}">
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
    <script type="text/javascript" src="/uploadify/jquery.uploadify.min.js"></script>
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
                    url:'/admin/tag/update/{{$tag->tag_id}}',
                    data:shuju,
                    dataType:'json',
                    type:'post',
                    success:function(data){
                        //alert(data);
                        if(data.result === true){
                            // 添加数据成功
                            layer.alert('修改成功',function(){
                                parent.window.location.href = parent.window.location.href;
                                // 关闭当前添加页面
                                layer_close();
                            });
                        }else{
                            // 添加数据失败
                            // 获取错误信息
                            var errors = data.info;
                            console.log(errors);
                            layer.alert(errors,{icon:5});
                        }
                    }

                });
            });
        });
    </script>

@endsection