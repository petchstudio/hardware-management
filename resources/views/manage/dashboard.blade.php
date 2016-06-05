@extends('manage')

@section('link-plugins')
<link href="{{ asset('assets/js/plugins/jquery.bootgrid/1.3.1/jquery.bootgrid.min.css') }}" rel="stylesheet">
@stop

@section('script-plugins')
<script src="{{ asset('assets/js/plugins/jquery.bootgrid/1.3.1/jquery.bootgrid.min.js') }}"></script>
<script type = "text/javascript" >
$(document).ready(function() {
    var grid = $("#data-table-request").bootgrid({
        ajax: true,
        ajaxSettings: {
            method: "GET",
        },
        url: "{!! url('request?json=true') !!}",
        templates: {
            header: "<div id=\"@{{ctx.id}}\" class=\"panel-heading @{{css.header}}\"><div class=\"row\"><div class=\"col-md-4 panel-title\">ประวัติการขอใช้บริการล่าสุด</div><div class=\"col-md-8 actionBar\"><p class=\"@{{css.search}}\"></p><p class=\"@{{css.actions}}\"></p></div></div></div>",
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
                return '#'+str_pad(row[column.id], 6);
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
        },
    });
});
</script>
@stop

@section('content')
    <div class="row text-center">
        <div class="col-xs-12{{ Auth::user()->admin() ? ' col-md-4':' col-sm-6' }}">
        	<a href="{{ url('material/requisition') }}" class="btn btn-lg btn-block p-t-15 p-b-15 m-b-15 btn-info">
        		เบิกวัสดุ
        	</a>
        </div>
        <div class="col-xs-12{{ Auth::user()->admin() ? ' col-md-4':' col-sm-6' }}">
        	<a href="{{ url('equipment/borrow') }}" class="btn btn-lg btn-block p-t-15 p-b-15 m-b-15 btn-info">
        		ยืมครุภัณฑ์
        	</a>
        </div>
        {{--<div class="col-xs-12{{ Auth::user()->admin() ? ' col-lg-3':' col-md-4' }}">
        	<a href="{{ url('laboratory/using') }}" class="btn btn-lg btn-block p-t-15 p-b-15 m-b-15 btn-info">
        		ขอใช้ห้องปฏิบัติการ
        	</a>
        </div>--}}
        @if( Auth::user()->admin() )
        <div class="col-xs-12 col-md-4">
        	<a href="{{ url('admin/request') }}" class="btn btn-lg btn-block p-t-15 p-b-15 m-b-15 btn-success">
        		อนุมัติคำขอใช้บริการ
        	</a>
        </div>
        @endif
    </div>

    <div class="panel hidden">
        <table id="data-table-request-admin" class="table table-striped">
            <thead>
                <tr>
                    <th data-column-id="id" data-formatter="zeropad" data-order="desc" data-header-css-class="hidden-xs" data-css-class="hidden-xs" data-width="120px">รหัสคำขอ</th>
                    <th data-column-id="hardware_name">ชื่ออุปกรณ์</th>
                    <th data-column-id="request_type" data-formatter="type">ชนิด</th>
                    <th data-column-id="datetime_start" data-formatter="date" data-header-css-class="hidden-xs" data-css-class="hidden-xs" data-width="140px">วันที่ยืม</th>
                    <th data-column-id="datetime_return" data-formatter="date" data-header-css-class="hidden-xs" data-css-class="hidden-xs" data-width="140px">วันที่คืน</th>
                    <th data-column-id="status" data-formatter="status" data-width="120px">สถานะ</th>
                </tr>
            </thead>
        </table>
    </div>

    <div class="panel">
        <table id="data-table-request" class="table table-striped">
            <thead>
                <tr>
                    <th data-column-id="id" data-formatter="zeropad" data-order="desc" data-header-css-class="hidden-xs" data-css-class="hidden-xs" data-width="120px">รหัสคำขอ</th>
                    <th data-column-id="hardware_name">ชื่ออุปกรณ์</th>
                    <th data-column-id="request_type" data-formatter="type">ชนิด</th>
                    <th data-column-id="datetime_start" data-formatter="date" data-header-css-class="hidden-xs" data-css-class="hidden-xs" data-width="140px">วันที่ยืม</th>
                    <th data-column-id="datetime_return" data-formatter="date" data-header-css-class="hidden-xs" data-css-class="hidden-xs" data-width="140px">วันที่คืน</th>
                    <th data-column-id="status" data-formatter="status" data-width="120px">สถานะ</th>
                </tr>
            </thead>
        </table>
    </div>
@stop