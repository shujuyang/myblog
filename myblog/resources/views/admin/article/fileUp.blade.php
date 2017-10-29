@extends('/admin/layout/layout')
@section('content')
<form class="form form-horizontal" enctype="multipart/form-data" id="uploadForm">
    {{ csrf_field() }}

    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>文件：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="file"  name="Filedata" id="Filedata">
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3"></label>
        <div class="formControls col-xs-8 col-sm-9">
            <p></p><input type="text" id="fileName" class="input-text" value="" readonly="readonly" /></p>
        </div>
    </div>
    <div class="row cl">
        <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
            <input class="btn btn-primary radius" type="submit" id="subBtn" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
        </div>
    </div>
</form>
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">

    $(function() {
        $('#uploadForm').submit(function(e){
            e.preventDefault();
        });
        $('#subBtn').click(function() {
            $.ajax({
                url: '/admin/article/fileUp',
                type: 'POST',
                cache: false,
                data: new FormData($('#uploadForm')[0]),
                processData: false,
                contentType: false
            }).done(function(res) {
                res = JSON.parse(res)
                var filename = res.filename;
                $("#fileName").val(filename);
            }).fail(function(res) {});
        })
    })

</script>
</article>
@endsection