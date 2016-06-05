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
function swalConfirm(grid, title, text, confirmButtonText, url, id)
{
    swal({
        title: title,
        text: text,
        type: "warning",
        showCancelButton: true,
        cancelButtonText: "ยกเลิก",
        confirmButtonText: confirmButtonText,
    }, function() {
        $.post(url, {
            id: id
        },
        "json").done(function(data) {
            if( data.status == true ) {
                swal(data.msg, false, "success");
                grid.bootgrid("reload");
            } else if( data.status == 'TokenMismatch' ) {
                window.location.reload(true);
            } else {
                swal(data.msg, data.desc, "error");
            }
        }).fail(function(data) {
            swal("Error " + data.status, data.statusText, "error");
        });
    });
}

$(document).ready(function() {
    var grid = $("#data-table-hardware").bootgrid({
        ajax: true,
        ajaxSettings: {
            method: "GET",
        },
        url: "{!! url(''. $type.'/'.$prefix[$type]['en'] .'?json=true') !!}",
        templates: {
            header: "<div id=\"@{{ctx.id}}\" class=\"panel-heading @{{css.header}}\"><div class=\"row\"><div class=\"col-md-4 panel-title\">{{ $prefix[$type]['th'].$name[$type] }}</div><div class=\"col-md-8 actionBar\"><p class=\"@{{css.search}}\"></p><p class=\"@{{css.actions}}\"></p></div></div></div>",
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
            "quantity": function(column, row) {
                var quantity = row['quantity']-row['quantity_use'];
                return parseInt(quantity).toLocaleString();
            },
            "status": function(column, row) {
                if(row.status == 0)
                    return "<span class=\"text-green\">ปกติ</span>";
                else if(row.status == 1)
                    return "<span class=\"text-red\">เสีย</span>";
                else
                    return "<span class=\"text-orange\">ไม่ทราบ</span>";
            },
            "date": function(column, row) {
                return "<span title=\""+row[column.id]+"\">"+moment(row[column.id]).fromNow()+"</span>";
            },
            "commands": function(column, row) {
                var disabled = '';
                if(row.status > 0)
                    disabled = ' disabled="disabled"';

                return "<button type=\"button\" data-row-id=\"" + row.id + "\" class=\"btn btn-xs btn-info command-request\""+ disabled +">{{ $prefix[$type]['th'].$name[$type] }}</button> ";
            },
        },
    }).on("loaded.rs.jquery.bootgrid", function() {
        $('[data-toggle="tooltip"]').tooltip();

        grid.find(".command-request").on("click", function(e) {
            $('#modal').modal({
                remote: "{{ url(''.$type.'/create') }}?id=" + $(this).data("row-id"),
            })
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
                    <th data-column-id="category" data-header-css-class="hidden-xs" data-css-class="hidden-xs" data-width="20%">ประเภท</th>
                    <th data-column-id="quantity" data-type="numeric" data-formatter="quantity" data-width="100px">จำนวนคงเหลือ</th>
                    <th data-column-id="status" data-formatter="status" data-width="80px">สถานะ</th>
                    <th data-column-id="commands" data-formatter="commands" data-sortable="false" data-width="90px"></th>
    				</tr>
    			</thead>
    		</table>
    </div>
@stop