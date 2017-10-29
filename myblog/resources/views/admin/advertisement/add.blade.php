@extends('/admin/layout/layout')
@section('content')


    <article class="page-container">
        <form class="form form-horizontal" id="form-admin-add">
            {{csrf_field()}}

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>广告标题：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" id="username" name="username">
                </div>
            </div>

            <link rel="stylesheet" href="/uploadify/uploadify.css">
            <script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
            <script type="text/javascript" src="/uploadify/jquery.uploadify.min.js"></script>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>头像：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="file" id="mypicture" name="mypicture">
                </div>
            </div>
            <div class="row cl" id="div_img" style="display: none">
                <label class="form-label col-xs-4 col-sm-3"></label>
                <div class="formControls col-xs-8 col-sm-9">
                    <p><img id="show_pic" src="" alt="" width="200" height="100"></p>
                    <p><input type="text" class="input-text" name="mg_pic" value="" readonly="readonly" /></p>
                </div>
            </div>

            <script type="text/javascript">
                $(function(){
                    $("#mypicture").uploadify({
                        'formData'	:	{
                            'timestamp'	:	"{{time()}}",
                            '_token'		: 	'{{csrf_token()}}'
                        },
                        'swf'	:	'/uploadify/uploadify.swf',
                        // 服务器端上传附件的地址
                        'uploader' : '/admin/advertisement/up_pic',
                        'onUploadSuccess' : function(file,data,response){
                            // response:true/false
                            // file 上传附件名字
                            // data 接受服务器端返回的信息
                            var obj =JSON.parse(data);
                            if(obj.success == true){
                                $("#div_img").show();
                                // 显示上传好的附件
                                $('#show_pic').attr('src',obj.filename);
                                // 把附件的名字赋予给当前form表单 input 框 mg_pic
                                $('[name=mg_pic]').val(obj.filename);
                            }
                        }
                    });
                });
            </script>


            <script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.config.js"></script>
            <script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.all.min.js"> </script>
            <script type="text/javascript" charset="utf-8" src="/ueditor/lang/zh-cn/zh-cn.js"></script>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">备注：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea name="adv_desc" id="adv_desc" style="width: 460px;height: 130px" class="textarea"  placeholder="说点什么...100个字符以内" dragonfly="true" onKeyUp="$.Huitextarealength(this,100)"></textarea>
                    <p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
                </div>
                <script>
                    var ue = UE.getEditor('adv_desc',{toolbars: [[
                        'fullscreen', 'source', '|', 'undo', 'redo', '|',
                        'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|'
                    ]]});
                </script>
                <style type="text/css" media="screen">
                    .textarea{
                        height: 216px;
                        padding: 0;
                    }
                </style>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </article>

    <!--_footer 作为公共模版分离出去-->
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
                    url:'/admin/advertisement/add',
                    data:shuju,
                    dataType:'json',
                    type:'post',
                    success:function(data){
                        //alert(data);
                        if(data === true){
                            // 添加数据成功
                            layer.alert('添加成功',function(){
                                parent.window.location.href = parent.window.location.href;
                                // 关闭当前添加页面
                                layer_close();
                            });
                        }else{
                            // 添加数据失败
                            // 获取错误信息
                            var errors = "{{\Illuminate\Support\Facades\Session::get('addErrors')}}";
                            console.log(errors);
                            layer.alert(errors,{icon:5});
                        }
                    }

                });
            });
        });
    </script>
    <!--/请在上方写此页面业务相关的脚本-->
@endsection