@extends('manage')

@section('link-plugins')
<link href="{{ asset('assets/js/plugins/jquery.bootgrid/1.3.1/jquery.bootgrid.min.css') }}" rel="stylesheet">
@stop

@section('script-plugins')
<!-- Data Table -->
<script src="{{ asset('assets/js/plugins/jquery.bootgrid/1.3.1/jquery.bootgrid.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-sweetalert/lib/sweet-alert.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery-validation/1.14.0/dist/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/validate.js') }}"></script>
<script type = "text/javascript" >
$(document).ready(function() {
    var grid = $("#data-table-hardware").bootgrid({
        ajax: true,
        ajaxSettings: {
            method: "GET",
        },
        url: "{!! url('admin/'. $type .'?json=true') !!}",
        templates: {
            header: "<div id=\"@{{ctx.id}}\" class=\"panel-heading @{{css.header}}\"><div class=\"row\"><div class=\"col-md-4 panel-title\">{{ $name[$type] }}ทั้งหมด</div><div class=\"col-md-8 actionBar\"><p class=\"@{{css.search}}\"></p><p class=\"@{{css.actions}}\"></p></div></div></div>",
        },
        css: {
            icon: 'zmdi icon',
            iconColumns: 'zmdi-view-module',
            iconDown: 'zmdi-caret-down',
            iconSearch: "zmdi-search",
            iconRefresh: 'zmdi-refresh',
            iconUp: 'zmdi-caret-up'
        },
        formatters: {
            "zeropad": function(column, row) {
                return str_pad(row[column.id], 4);
            },
            "number": function(column, row) {
                return parseInt(row[column.id]).toLocaleString();
            },
            "status": function(column, row) {
                if(row.status == 0)
                    return "ปกติ";
                else if(row.status == 1)
                    return "เสีย";
                else
                    return "ไม่ทราบ";
            },
            "date": function(column, row) {
                return "<span title=\""+row[column.id]+"\">"+moment(row[column.id]).fromNow()+"</span>";
            },
            "balance": function(column, row) {
                return parseInt(row.quantity - row.quantity_use).toLocaleString();
            },
            "commands": function(column, row) {
                btnEdit = "<button type=\"button\" data-row-id=\"" + row.id + "\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"แก้ไข\" class=\"btn btn-xs btn-icon command-edit\"><span class=\"zmdi zmdi-edit\"></span></button> ";
                btnDelete  = "<button type=\"button\" data-row-id=\"" + row.id + "\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"ลบ\" class=\"btn btn-xs btn-icon command-delete\"><span class=\"zmdi zmdi-delete\"></span></button>";

                return btnEdit + btnDelete;
            },
        },
    }).on("loaded.rs.jquery.bootgrid", function() {
        $('[data-toggle="tooltip"]').tooltip();

        grid.find(".command-edit").on("click", function(e) {
            $('#modal').modal({
                remote: "{{ url('admin/'.$type) }}/" + $(this).data("row-id") + "/edit",
            })
        }).end().find(".command-delete").on("click", function(e) {
            var id = $(this).data("row-id");

            swal({
                title: 'ลบข้อมูล',
                text: 'ยืนยันการลบข้อมูล ?',
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "ยกเลิก",
                confirmButtonText: 'ลบข้อมูล',
            }, function() {
                $.ajax({
                    url: '{{ url('admin/'.$type) }}/'+ id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    }
                })
                .done(function(data) {
                    if( data == 'true' ) {
                        swal("ลบข้อมูล", "ลบข้อมูลสำเร็จ", "success");
                        grid.bootgrid("reload");
                    } else {
                        swal("Error", data, "error");
                    }
                })
                .fail(function(data) {
                    swal("Error", data, "error");
                });
            });
        });
    });
});
</script>
@stop

@section('content')
    <div class="panel">
    	<table id="data-table-hardware" class="table table-striped">
    		<thead>
    			<tr>
                    <th data-column-id="id" data-formatter="zeropad" data-order="desc" data-header-css-class="hidden-xs" data-css-class="hidden-xs" data-width="65px">#</th>
                    <th data-column-id="name">รายการ</th>
                    <th data-column-id="brand" data-width="12%">ยี่ห้อ</th>
                    <th data-column-id="model" data-width="10%">รุ่น</th>
                    <th data-column-id="category" data-header-css-class="hidden-xs" data-css-class="hidden-xs" data-width="10%">ประเภท</th>
                    <th data-column-id="quantity_use" data-type="numeric" data-formatter="number" data-width="80px">ใช้งาน</th>
                    <th data-type="numeric" data-formatter="balance" data-width="80px">คงเหลือ</th>
                    <th data-column-id="status" data-formatter="status" data-width="80px">สถานะ</th>
                    <th data-column-id="updated_at" data-formatter="date" data-header-css-class="hidden-xs" data-css-class="hidden-xs" data-width="120px">แก้ไข</th>
                    <th data-column-id="get_at" data-formatter="date" data-header-css-class="hidden-xs" data-css-class="hidden-xs" data-width="120px">รับเมื่อ</th>
                    <th data-column-id="commands" data-formatter="commands" data-sortable="false" data-width="60px"></th>
    			</tr>
    		</thead>
    	</table>
        <div class="panel-body text-right">
            <a href="{{ url('admin/category?type='. $type) }}" class="btn btn-info" data-toggle="modal" data-target="#modal">
                จัดการประเภท
            </a>
            <a href="{{ url('admin/'. $type .'/create') }}" class="btn btn-info" data-toggle="modal" data-target="#modal">
                เพิ่ม{{ $name[$type] }}
            </a>
        </div>
    </div>
@stop