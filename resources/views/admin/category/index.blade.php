<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title">จัดการประเภท{{ $name[$type] }}</h4>
</div>
<div class="modal-body">
	<table id="data-table-category" class="table table-striped">
		<thead>
			<tr>
				<th data-column-id="name" data-formatter="name">ชื่อประเภท</th>
				<th data-column-id="commands" data-formatter="commands" data-sortable="false" data-width="60px"></th>
			</tr>
		</thead>
	</table>
    <div class="row">
        <form id="form-create-category">
            <div class="form-group">
                <div class="col-xs-8 col-sm-10">
                    <input type="text" class="form-control" id="input-name" name="name" placeholder="ชื่อประเภท">
                </div>
                <div class="col-xs-4 col-sm-2">
                    <button type="submit" class="btn btn-block btn-primary" id="create-category">เพิ่ม</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    var gridCategory = $("#data-table-category").bootgrid({
        ajax: true,
        ajaxSettings: {
            method: "GET",
        },
        url: "{!! url('admin/category?json=true&type='. $type) !!}",
        css: {
            icon: 'zmdi icon',
            iconColumns: 'zmdi-view-module',
            iconDown: 'zmdi-caret-down',
            iconSearch: "zmdi-search",
            iconRefresh: 'zmdi-refresh',
            iconUp: 'zmdi-caret-up'
        },
        formatters: {
            "name": function(column, row) {
                return "<span>" + row.name + "</span>"
            },
            "commands": function(column, row) {
                btnEdit = "<button type=\"button\" data-row-id=\"" + row.id + "\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"แก้ไข\" class=\"btn btn-xs btn-icon command-edit\"><span class=\"zmdi zmdi-edit\"></span></button> ";
                btnDelete  = "<button type=\"button\" data-row-id=\"" + row.id + "\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"ลบ\" class=\"btn btn-xs btn-icon command-delete\"><span class=\"zmdi zmdi-delete\"></span></button>";

                return btnEdit + btnDelete;
            },
        },
        navigation: 0
    }).on("loaded.rs.jquery.bootgrid", function() {
        $('[data-toggle="tooltip"]').tooltip();

        gridCategory.find(".command-edit").on("click", function(e) {
            var id = $(this).data("row-id"),
            td = $(this).parents('tr').find('td:first-child'),
            span = td.find('span');
            value = span.html();

            if( td.find('input').length ) {
                value = td.find('input').val();

                $.ajax({
                    url: '{{ url('admin/category') }}/'+ id,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        name: value
                    },
                })
                .done(function() {
                    td.find('input').remove();
                    span.html(value).show();
                })
                .fail(function(data) {
                    swal("Error", data, "error");
                });
            } else {
                td.append("<input type=\"text\" value=\"" + value + "\" placeholder=\"ชื่อประเภท\">");
                span.hide();
            }
        }).end().find(".command-delete").on("click", function(e) {
            var id = $(this).data("row-id");

            swal({
                title: 'ยืนยันการลบข้อมูล ?',
                text: 'เมื่อลบข้อมูลแล้ว จะไม่สามารถเรียกคืนได้',
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "ยกเลิก",
                confirmButtonText: 'ลบข้อมูล',
            }, function() {
                $.ajax({
                    url: '{{ url('admin/category') }}/'+ id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    }
                })
                .done(function(data) {
                    if( data == 'true' ) {
                        gridCategory.bootgrid("reload");
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

    $('#form-create-category').validate({
        rules: {
            name: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "โปรดป้อนชื่อประเภท",
            },
        },
        onkeyup: false,
        submitHandler: function(form) {
            var name = $('#input-name'),
            btn = $('#create-category');

            name.prop('disabled', true);
            btn.prop('disabled', true);

            $.post('{{ url('admin/category') }}', {
                _token: '{{ csrf_token() }}',
                type: '{{ $type }}',
                name: name.val()
            }, function(data, textStatus, xhr) {
                name.prop('disabled', false);
                btn.prop('disabled', false);
                name.val('');
                $("#data-table-category").bootgrid("reload");
            });
        }
    });
});
</script>