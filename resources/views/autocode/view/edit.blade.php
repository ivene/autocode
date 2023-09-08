
<script type="text/javascript">
    function edit_{{$tableinfo->name}}(index) {
        index = Number(index);
        if(index !=-1){
            var data = myTable.rows(index).data()[0];
            loadData(data);
        }else{
            $("#{{$tableinfo->name}}_edit_form")[0].reset();
            $("#id").val(0);
        }
        $('#{{$tableinfo->name}}_edit_modal').modal({'show': true, "backdrop": 'static'});
    }

    function save_{{$tableinfo->name}}(){
          $.ajax({
             type:"POST",
             dataType:"json",
             url:"{!! $view->save_url !!}",
             data:$("#{{$tableinfo->name}}_edit_form").serialize(),
             success: function (result) {
                 if (result.code == "10000") {
                     Swal.fire({title:'操作成功',text:result.msg,type: 'success'})
                         .then(function () {
                             $('#{{$tableinfo->name}}_edit_modal').modal('hide');
                             myTable.ajax.reload(null,false);
                         });
                 } else {
                     Swal.fire(result.msg,"",'error');
                 }
             },
             error: function (result) {
                 $.each(result.responseJSON.errors, function (k, val) {
                     Swal.fire(val[0],"",'error');
                     return false;
                 });
             }
         });
         return false;

      }
</script>

<div class="modal fade" id="{{$tableinfo->name}}_edit_modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title">{{$tableinfo->title}}信息</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="{{$tableinfo->name}}_edit_form" name="{{$tableinfo->name}}_edit_form">
                    <div class="card-body">
                        @{{csrf_field()}}
                        <input type="hidden" id="id" name="id" value="0">
@foreach($tableinfo->fields as $field)
@if($field->name == 'status')
                        <div class="form-group row">
                            <label for="class_name" class="col-sm-2 col-form-label">分类状态</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" id="status" name="status">
                                    <option value="1">正常</option>
                                    <option value="0">禁止</option>
                                </select>
                            </div>
                        </div>
@else
<div class="form-group row">
    <label for="{{$field->name}}" class="col-sm-2 col-form-label">{{$field->title}}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="{{$field->name}}" name="{{$field->name}}">
    </div>
</div>
@endif
@endforeach
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-info" id="save_{{$tableinfo->name}}_button" name="save_{{$tableinfo->name}}_button" onclick="save_{{$tableinfo->name}}()">保存修改</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

