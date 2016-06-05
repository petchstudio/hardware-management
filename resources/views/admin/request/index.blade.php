@extends('manage')

@section('link-plugins')
<link href="{{ asset('assets/js/plugins/jquery.bootgrid/1.3.1/jquery.bootgrid.min.css') }}" rel="stylesheet">
@stop

@section('script-plugins')
<!-- Data Table -->
<script src="{{ asset('assets/js/plugins/jquery.bootgrid/1.3.1/jquery.bootgrid.min.js') }}"></script>
<script type = "text/javascript" >
$(document).ready(function() {
    var grid = $("#data-table-request").bootgrid({
        ajax: true,
        ajaxSettings: {
            method: "GET",
        },
        selection: true,
        multiSelect: true,
        post: function ()
        {
            return {
                filter: $('#select-filter').val(),
            };
        },
        url: "{!! url('admin/request?json=true') !!}",
        selection: true,
        multiSelect: true,
        templates: {
            header: "<div id=\"@{{ctx.id}}\" class=\"panel-heading @{{css.header}}\"><div class=\"row\"><div class=\"col-md-4 panel-title\">คำขอใช้อุปกรณ์ทั้งหมด</div><div class=\"col-md-8 actionBar\"><p class=\"@{{css.search}}\"></p><p class=\"@{{css.actions}}\"></p><button class=\"btn btn-default m-l-15 btn-report\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"ออกรายงาน\"><span class=\"zmdi zmdi-collection-pdf\"></span></button></div></div></div>",
            search: "<div class=\"@{{css.search}}\"><div class=\"input-group\"><span class=\"@{{css.icon}} input-group-addon @{{css.iconSearch}}\"></span> <input type=\"text\" class=\"@{{css.searchField}}\" placeholder=\"@{{lbl.search}}\" /></div></div><select class=\"selectpicker m-r-20\" id=\"select-filter\" data-width=\"auto\"><option value=\"all\">ทั้งหมด</option><option value=\"wait\">รออนุมัติ</option><option value=\"approve\">อนุมัติ</option><option value=\"receive\">รับแล้ว</option><option value=\"using\">ใช้งาน</option><option value=\"return\">คืนเรียบร้อย</option><option value=\"lost\">สูญหาย</option></select>",
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
                return '#'+str_pad(row.id, 6);
            },
            "number": function(column, row) {
                return parseInt(row[column.id]).toLocaleString();
            },
            "date": function(column, row) {
                return "<span title=\""+row[column.id]+"\">"+moment(row[column.id]).locale('th').format('DD/MM/YYYY')+"</span>";
            },
            "type": function(column, row) {
                var type = {
                    equipment: 'ครุภัณฑ์',
                    material: 'วัสดุ',
                };
                
                return type[row[column.id]];
            },
            "status": function(column, row) {
                var status = {
                    wait: {
                        text: 'รออนุมัติ',
                        css: 'orange',
                    },
                    approve: {
                        text: 'อนุมัติ',
                        css: 'success',
                    },
                    receive: {
                        text: 'รับแล้ว',
                        css: 'info',
                    },
                    using: {
                        text: 'ใช้งาน',
                        css: 'warning',
                    },
                    return: {
                        text: 'คืนเรียบร้อย',
                        css: 'success',
                    },
                    lost: {
                        text: 'สูญหาย',
                        css: 'danger',
                    },
                };

                return '<span class="text-'+status[row[column.id]]['css']+'">'+status[row[column.id]]['text']+'</span>';
            },
            "commands": function(column, row) {
                return  "<button type=\"button\" data-row-id=\"" + row.id + "\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"แก้ไข\" class=\"btn btn-default btn-xs btn-icon command-edit\"><span class=\"zmdi zmdi-edit\"></span></button> "
                        +
                        "<a href=\"{{ url('admin/report') }}/" + row.id + "/pdf\" target=\"_blank\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"ออกรายงาน\" class=\"btn btn-default btn-xs btn-icon command-report\"><span class=\"zmdi zmdi-collection-pdf\"></span></a>";
            },
        },
    }).on("loaded.rs.jquery.bootgrid", function() {
        $('[data-toggle="tooltip"]').tooltip();

        grid.find(".command-edit").on("click", function(e) {
            $('#modal').modal({
                remote: "{{ url('admin/request') }}/" + $(this).data("row-id") + "/edit",
            })
        });
    });

    $('body').on('change', '#select-filter', function(event) {
        grid.bootgrid('reload');
        console.log($(this).val())
    }).on('click', '.btn-report', function(event) {
        event.preventDefault();
        if($('tbody input.select-box:checked').length > 0)
        {
            var rowIds = [];

            $.each($('tbody input.select-box:checked'), function(index, val) {
                rowIds.push($(val).val());
            });

            window.open("{{ url('admin/report') }}/" + rowIds.join(",") + "/pdf", '_blank');
        }
        else
        {
            swal("ไม่ได้เลือกคำข้อ", 'โปรดเลือกคำข้อที่จะออกรายงาน', "error");
        }
    });
});
</script>
@stop

@section('content')
    <div class="panel">
        <table id="data-table-request" class="table table-striped">
            <thead>
                <tr>
                    <th data-column-id="id" data-type="numeric" data-identifier="true" data-formatter="zeropad" data-order="desc" data-header-css-class="hidden-xs" data-css-class="hidden-xs" data-width="120px">รหัสคำขอ</th>
                    <th data-column-id="hardware_name">ชื่ออุปกรณ์</th>
                    <th data-column-id="request_type" data-formatter="type">ชนิด</th>
                    <th data-column-id="user">ผู้ขอ</th>
                    <th data-column-id="datetime_start" data-formatter="date" data-header-css-class="hidden-xs" data-css-class="hidden-xs" data-width="140px">วันที่ยืม</th>
                    <th data-column-id="datetime_return" data-formatter="date" data-header-css-class="hidden-xs" data-css-class="hidden-xs" data-width="140px">วันที่คืน</th>
                    <th data-column-id="status" data-formatter="status" data-width="100px">สถานะ</th>
                    <th data-column-id="commands" data-formatter="commands" data-sortable="false" data-width="70px"></th>
                </tr>
            </thead>
        </table>
    </div>
@stop