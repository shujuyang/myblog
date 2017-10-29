@extends('/admin/layout/layout')
@section('content')


    <article class="page-container">
        <form class="form form-horizontal" id="form-admin-add">
            {{csrf_field()}}

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>文章标题：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" placeholder="" id="ar_title" name="ar_title">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>编辑者：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" placeholder="" id="ar_editor" name="ar_editor">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>最新：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box">
                        <input name="is_new" type="radio"  value="是" checked for="new-1">
                        <label for="sex-1">是</label>
                    </div>
                    <div class="radio-box">
                        <input name="is_new" type="radio" value="否" id="sex-2">
                        <label for="sex-2">否</label>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>最热：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box">
                        <input name="is_hot" type="radio" id="hot-1" value="是" checked>
                        <label for="hot-1">是</label>
                    </div>
                    <div class="radio-box">
                        <input name="is_hot" type="radio" id="hot-2" value="否">
                        <label for="hot-2">否</label>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>头条：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box">
                        <input name="is_top" type="radio" id="hot-1" value="是" checked>
                        <label for="hot-1">是</label>
                    </div>
                    <div class="radio-box">
                        <input name="is_top" type="radio" id="hot-2" value="否">
                        <label for="hot-2">否</label>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>所属标签：</label>
                <div class="formControls col-xs-8 col-sm-9">
                        @foreach($tag as $k => $v)
                        <label for="ar_tag_name{{$k}}">{{$v->tag_name}}</label>
                         <input type="checkbox" id="ar_tag_name{{$k}}" name="ar_tag_name[]" value="{{$v->tag_id}}">
                        &nbsp;&nbsp;
                        @endforeach

                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>所属栏目：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    @foreach($column as $k => $v)
                        <label for="ar_column_id{{$k}}">{{$v->col_name}}</label>
                        <input type="checkbox" id="ar_column_id{{$k}}" name="ar_column_id[]" value="{{$v->col_id}}">
                        &nbsp;&nbsp;
                    @endforeach

                </div>
            </div>
            <script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
            <script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.config.js"></script>
            <script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.all.js"> </script>
            <script type="text/javascript" charset="utf-8" src="/ueditor/lang/zh-cn/zh-cn.js"></script>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">文章简介：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea name="ar_desc" id="ar_desc" style="width: 460px;height: 130px" class="textarea"  placeholder="说点什么...100个字符以内" dragonfly="true" onKeyUp="$.Huitextarealength(this,100)"></textarea>
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">文章内容：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <div name="ar_content" id="ar_content" style="width: 460px;height: 130px" class="textarea"  placeholder="说点什么...100个字符以内" dragonfly="true"></div>
                </div>
                <script>
                    var ue = UE.getEditor('ar_content',{
                        initialFrameWidth :500,
                        initialFrameHeight:320,
                        scaleEnabled:true,toolbars: [[
                            'anchor', //锚点
                            'undo', //撤销
                            'redo', //重做
                            'bold', //加粗
                            'indent', //首行缩进
                            'snapscreen', //截图
                            'italic', //斜体
                            'underline', //下划线
                            'strikethrough', //删除线
                            'subscript', //下标
                            'fontborder', //字符边框
                            'superscript', //上标
                            'formatmatch', //格式刷
                            'source', //源代码
                            'blockquote', //引用
                            'pasteplain', //纯文本粘贴模式
                            'selectall', //全选
                            'print', //打印
                            'preview', //预览
                            'horizontal', //分隔线
                            'removeformat', //清除格式
                            'time', //时间
                            'date', //日期
                            'unlink', //取消链接
                            'insertrow', //前插入行
                            'insertcol', //前插入列
                            'mergeright', //右合并单元格
                            'mergedown', //下合并单元格
                            'deleterow', //删除行
                            'deletecol', //删除列
                            'splittorows', //拆分成行
                            'splittocols', //拆分成列
                            'splittocells', //完全拆分单元格
                            'deletecaption', //删除表格标题
                            'inserttitle', //插入标题
                            'mergecells', //合并多个单元格
                            'deletetable', //删除表格
                            'cleardoc', //清空文档
                            'insertparagraphbeforetable', //"表格前插入行"
                            'insertcode', //代码语言
                            'fontfamily', //字体
                            'fontsize', //字号
                            'paragraph', //段落格式
                            'simpleupload', //单图上传
                            'insertimage', //多图上传
                            'edittable', //表格属性
                            'edittd', //单元格属性
                            'link', //超链接
                            'emotion', //表情
                            'spechars', //特殊字符
                            'searchreplace', //查询替换
                            'map', //Baidu地图
                            'gmap', //Google地图
                            'insertvideo', //视频
                            'help', //帮助
                            'justifyleft', //居左对齐
                            'justifyright', //居右对齐
                            'justifycenter', //居中对齐
                            'justifyjustify', //两端对齐
                            'forecolor', //字体颜色
                            'backcolor', //背景色
                            'insertorderedlist', //有序列表
                            'insertunorderedlist', //无序列表
                            'fullscreen', //全屏
                            'directionalityltr', //从左向右输入
                            'directionalityrtl', //从右向左输入
                            'rowspacingtop', //段前距
                            'rowspacingbottom', //段后距
                            'pagebreak', //分页
                            'insertframe', //插入Iframe
                            'imagenone', //默认
                            'imageleft', //左浮动
                            'imageright', //右浮动
                            'attachment', //附件
                            'imagecenter', //居中
                            'wordimage', //图片转存
                            'lineheight', //行间距
                            'edittip ', //编辑提示
                            'customstyle', //自定义标题
                            'autotypeset', //自动排版
                            'webapp', //百度应用
                            'touppercase', //字母大写
                            'tolowercase', //字母小写
                            'background', //背景
                            'template', //模板
                            'scrawl', //涂鸦
                            'music', //音乐
                            'inserttable', //插入表格
                            'drafts', // 从草稿箱加载
                            'charts', // 图表
                         ]]});
                </script>
                <style type="text/css" media="screen">
                    .textarea{
                        height: 500px;
                        padding: 0;
                    }
                </style>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3" style="z-index:1000;">
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </article>


    <!--_footer 作为公共模版分离出去-->

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
                    url:'/admin/article/add',
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
                            console.log(errors);
                            layer.alert(errors,{icon:5});
                        }
                    }

                });
            });
        });
    </script>

@endsection