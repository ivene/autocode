@@extends("base.master")
@@section('title', "{{$tableinfo->title}}管理")
@@section("menuname","{{$tableinfo->title}}管理")
@@section("smallname","{{$tableinfo->title}}列表")

@@section("css")
    @@include("base.css.datatables")
@@endsection

@@section("js")
    @@include("base.js.datatables")
    <!-- Page specific script -->
    <script type="text/javascript">
        let myTable;
        $(function () {
            myTable = initDataTable();
            $('.select2').select2();
        });
        function initDataTable() {
            let table;
            table = $("#mytable").DataTable({
                "responsive": true,
                "serverSide": true,
                'stateSave': true,
                "retrieve": true,
                "processing": true,
                "autoWidth": false,
                "order": [[0, "desc"]],
                "ajax": {
                    "url": "{!! urldecode($view->list_url) !!}",
                    "type": "POST",
                    "dataType": "json",
                    "data": {'_token': '@{{ csrf_token() }}'}
                },
                "columns": [
                    {"data": "{{$tableinfo->primary_key}}", "title": "编号"},
@foreach($tableinfo->fields as $field)
@if($field->name !== 'status')
                    {"data": "{{$field->name}}", "title": "{{$field->title}}"},
@else
                    {"data": "status_str", "title": "状态",
                        "render": function (data, type, row, meta) {
                            if (row.status === 0) {
                                return '<span class="badge badge-danger">' + row.status_str + '</span>';
                            } else {
                                return '<span class="badge badge-success">' + row.status_str + '</span>';
                            }
                        }
                    },
@endif
@endforeach
                    {"data": "status", "title": "操作", "orderable": false ,
                        "render": function (data, type, row, meta) {
                            $str = "<button class=\"btn btn-sm btn-info\" onclick='edit_{{$tableinfo->name}}(" + meta.row + ")'>编辑</button>";
                            return $str;
                        },
                    },
                ],
            });
            return table;
        }
    </script>
    @@endsection

@@section("content")
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <button type="button" class="btn btn-danger" onclick="edit_{{$tableinfo->name}}('-1')">新增{{$tableinfo->title}}</button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="mytable" class="table table-bordered table-striped">
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    {!! $view->edit_view !!}
@@endsection
