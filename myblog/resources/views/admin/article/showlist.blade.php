@extends('/admin/layout/layout')
@section('content')


    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 文章管理 <span class="c-gray en">&gt;</span> 文章列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <div class="text-c"> 日期范围：
            <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" class="input-text Wdate" style="width:120px;">
            <input type="text" class="input-text" style="width:250px" placeholder="输入文章名称" id="" name="">
            <button type="submit" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
        </div>

        <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a href="javascript:;" onclick="admin_add('添加文章','/admin/article/add','900','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加文章</a></span> <span class="r">共有数据：<strong>54</strong> 条</span> </div>
        <!-- jQuery -->
        <script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
        <!-- DataTables -->
        <script type="text/javascript" charset="utf8" src="/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>

        <table class="table table-border table-bordered table-bg" id="datatable">
            <thead>
            <tr>
                <th scope="col" colspan="13">文章列表</th>
            </tr>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="40">ID</th>
                <th width="150">文章标题</th>
                <th width="90">编辑者</th>
                <th width="150">文章内容</th>
                <th width="100">文章简介</th>
                <th width="80">所属标签</th>
                <th width="80">所属栏目</th>
                <th width="30">是否为最新</th>
                <th width="30">是否为热门</th>
                <th width="30">是否为置顶</th>
                <th width="70">创建时间</th>
                <th width="60">操作</th>
            </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
        </table>
        <link rel="stylesheet" href="/css/pagination.css">
    </div>
    <!--_footer 作为公共模版分离出去-->
    {{--<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>--}}
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
        function article_del(obj,id){
            layer.confirm('确认要删除吗？',function(index){
                $.ajax({
                    type: 'POST',
                    url: '/admin/article/del/'+id,
                    headers : {
                        "X-CSRF-TOKEN" : "{{ csrf_token() }}"
                    },
                    dataType: 'json',
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

        /*管理员-编辑*/
        function article_edit(title,url,w,h){
            layer_show(title,url,w,h);
        }

        /*datatables*/
        $(function(){
            //使用mydatatable"全局"变量把dataTable给接收起来，以便子级页面调用
            mydatatable = $('#datatable').dataTable({
                "order": [[ 1, "desc" ]],
                "stateSave": false,//状态保存
                "columnDefs": [
                    {"targets": [0,6,7],"orderable": false}// 制定列不参与排序
                ],
                "lengthMenu": [ 16,4,8,32 ],
                "paging": true,
                "info":     true,
                "searching": true,
                "ordering": true,
                "processing": true,
                "serverSide": true,
                "oLanguage": {
                    "sLengthMenu": "每页显示 _MENU_ 条记录",
                    "sZeroRecords": "对不起，查询不到任何相关数据",
                    "sInfo": "当前显示 _START_ 到 _END_ 条，共 _TOTAL_条记录",
                    "sInfoEmtpy": "找不到相关数据",
                    "sInfoFiltered": "数据表中共为 _MAX_ 条记录)",
                    "sProcessing": "正在加载中...",
                    "sSearch": "搜索",
                    "oPaginate": {
                        "sFirst": "第一页",
                        "sPrevious":" 上一页 ",
                        "sNext": " 下一页 ",
                        "sLast": " 最后一页 "
                    },
                },
                "ajax": {
                    "url": "{{ url('admin/article/showlist') }}",
                    "type": "POST",
                    'headers': {
                        'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                    },
                },
                //给各个"td"填充内容
                "columns": [
                    {'data':'a',"defaultContent": "<input type='checkbox'>"},
                    {'data':'ar_id'},
                    {'data':'e',"defaultContent":""},
                    {'data':'ar_editor'},
                    {'data':'ar_content'},
                    {'data':'ar_desc'},
                    {'data':'c',"defaultContent":""},
                    {'data':'d',"defaultContent":""},
                    {'data':'is_new'},
                    {'data':'is_hot'},
                    {'data':'is_top'},
                    {'data':'created_at'},
                    {'data':'b',"defaultContent": "",'className':'td-manager'},
                ],
                "createdRow":function(row,data,dataIndex){
                    //① 给最后td设置功能按钮
                    var anniu = "";
                    anniu += '<a title="编辑" href="javascript:;" onclick="article_edit(\'编辑\',\'/admin/article/update/'+data.ar_id+'\',800,\'\',510)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a><a title="删除" href="javascript:void(0);"  onclick="article_del(this,'+data.ar_id+')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>\n';
                    $(row).find('td:eq(12)').html(anniu);

                    //② 给tr设置class属性
                    $(row).addClass('text-c');
                    //⑤把第1列复选框设计为：<input type="checkbox" class='xiuzheng' id="lesson_ck_主键" value=课时主键值 />
                    $(row).find('td:eq(0) input').val(data.ar_id);  //设置value值
                    $(row).find('td:eq(0) input').attr('id','lesson_ck_'+data.ar_id); //设置id属性

                    var tag="";
                    var i;
                    for(i in data.tag){
                        tag += data.tag[i].tag_name+"，"
                    }
                    tag = tag.substring(0,tag.length-1);
                    $(row).find('td:eq(6)').html(tag);

                    var column="";
                    var j;
                    for(j in data.column){
                        column += data.column[j].col_name
                        column += ","
                    }
                    column = column.substring(0,column.length-1);
                    $(row).find('td:eq(7)').html(column);

                    var title = '<a href="/home/article/infoView/'+data.ar_id+'" target="_black">'+data.ar_title+'</a>';
                    $(row).find('td:eq(2)').html(title);
                },
            });
        });

    </script>
@endsection