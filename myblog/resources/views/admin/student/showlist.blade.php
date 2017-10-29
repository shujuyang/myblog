@extends('/admin/layout/layout')
@section('content')


    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 管理员列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">

        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l"><a href="/admin/student/getExcel"  class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 生成EXCEL </a></span>
        </div>


        <!-- jQuery -->
        <script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
        <!-- DataTables -->
        <script type="text/javascript" charset="utf8" src="/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
        <table id="datatable" class="table table-border table-bordered table-bg">
            <thead>
            <tr>
                <th scope="col" colspan="10">学生列表</th>
            </tr>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="40">ID</th>
                <th width="150">姓名</th>
                <th width="150">电话号码</th>
                <th width="150">邮箱</th>
                <th width="150">提交页面</th>
                <th width="150">报考类型</th>
                <th width="120">创建时间</th>
            </tr>
            </thead>
            <tbody></tbody>
            <tfooter></tfooter>
        </table>
        <link rel="stylesheet" href="/css/pagination.css">
    </div>
    <!--_footer 作为公共模版分离出去-->
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

        /*生成 EXCEL*/
        function getExcel(){
            $.ajax({
                type: 'POST',
                url: '/admin/article/getExcel',
                headers : {
                    "X-CSRF-TOKEN" : "{{ csrf_token() }}"
                },
                success: function(data){
                    console.log(data);
                },
                error:function(data) {
                    console.log(data.msg);
                },
            });
        }

        $(function(){
            //使用mydatatable"全局"变量把dataTable给接收起来，以便子级页面调用
            mydatatable = $('#datatable').dataTable({
                "order": [[ 1, "desc" ]],
                "stateSave": false,//状态保存
                "columnDefs": [
                    {"targets": [0,6],"orderable": false}// 制定列不参与排序
                ],
                "lengthMenu": [ 16,8,32 ],
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
                    "url": "{{ url('admin/student/showlist') }}",
                    "type": "POST",
                    'headers': {
                        'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                    },
                },
                //给各个"td"填充内容
                "columns": [
                    {'data':'a',"defaultContent": "<input type='checkbox'>"},
                    {'data':'st_id'},
                    {'data':'st_username'},
                    {'data':'st_phone'},
                    {'data':'st_email'},
                    {'data':'add_from'},
                    {'data':'reg_type.reg_name'},
                    {'data':'created_at'},
                ],
                "createdRow":function(row,data,dataIndex){
                    //console.log(data);
                    //该方法会"遍历"每个新生成的tr
                    //此处，可以对生成好的tr、td进行二次优化，改造
                    //row:就是生成的tr的dom对象，设置为$(row)就变为jquery对象
                    //data:服务器端传递回来的每条 数据记录
                    //dataIndex:是tr的下标索引号码
                    //② 给tr设置class属性
                    $(row).addClass('text-c');
                    //⑤把第1列复选框设计为：<input type="checkbox" class='xiuzheng' id="lesson_ck_主键" value=课时主键值 />
                    $(row).find('td:eq(0) input').val(data.st_id);  //设置value值
                    $(row).find('td:eq(0) input').attr('id','lesson_ck_'+data.st_id); //设置id属性
                },
            });
        });

    </script>
@endsection