<form id="form-create-request" class="form-horizontal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">{{ $prefix[$hardware->type]['th'].$name[$hardware->type] }}</h4>
	</div>
	<div class="modal-body">
        <div class="m-b-10">
            <strong>รายละเอียด{{ $name[$hardware->type] }}</strong>
        </div>
        <div class="form-group">
            <div class="col-sm-3 text-right">ชื่อ{{ $name[$hardware->type] }}</div>
            <div class="col-sm-9">{{ $hardware->name }}</div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-3 text-right">ยี่ห้อ</div>
            <div class="col-sm-9">{{ $hardware->brand }} รุ่น {{ $hardware->model }}</div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-3 text-right">ประเภท</div>
            <div class="col-sm-9"><span>{{ $hardware->category }}</span></div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-3 text-right">จำนวนที่มี</div>
            <div class="col-sm-9"><span>{{ $hardware->quantity_available }}</span></div>
        </div>
        
        <hr>

        <div class="m-b-10">
            <strong>รายละเอียดการขอ{{ $prefix[$hardware->type]['th'].$name[$hardware->type] }}</strong>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">วันที่{{ $prefix[$hardware->type]['th'].$name[$hardware->type] }}</label>
            <div class="col-sm-9">
                <input type="text" class="form-control datepicker" id="input-datestart" name="datestart">
            </div>
        </div>

        @if( $hardware->type == "equipment" )
        <div class="form-group">
            <label class="col-sm-3 control-label">วันที่คืน{{ $name[$hardware->type] }}</label>
            <div class="col-sm-9">
                <input type="text" class="form-control datepicker" id="input-datereturn" name="datereturn">
            </div>
        </div>
        @endif

        <div class="form-group">
            <label class="col-sm-3 control-label">จำนวน</label>
            <div class="col-sm-3">
                <input type="number" class="form-control" id="input-quantity" name="quantity" value="1" min="1" max="{{ $hardware->quantity_available }}">
            </div>
        </div>

	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
		<button type="submit" class="btn btn-primary">ส่งคำขอ</button>
	</div>
</form>

<script type="text/javascript">
$(document).ready(function(){
    var today = new Date();

    $('.datepicker').datepicker({
        format: "dd/mm/yyyy",
        todayBtn: "linked",
        language: "th",
        todayHighlight: true,
        startDate: new Date(today.getFullYear(), today.getMonth(), today.getDate()),
    });

	$('#form-create-request').validate({
        rules: {
            datestart: {
                required: true,
                date: true,
            },
@if( $hardware->type == "equipment" )
            datereturn: {
                required: true,
                date: true,
            },
@endif
            quantity: {
                required: true,
                number: true,
                min: 1,
                max: {{ $hardware->quantity_available }}
            },
        },
        messages: {
            datestart: {
                required: "โปรดระบุวันที่{{ $prefix[$hardware->type]['th'].$name[$hardware->type] }}",
                date: "วันที่ไม่ถูกต้อง",
            },
@if( $hardware->type == "equipment" )
            datereturn: {
                required: "โปรดระบุวันที่คืน{{ $name[$hardware->type] }}",
                date: "วันที่ไม่ถูกต้อง",
            },
@endif
            quantity: {
                required: "โปรดป้อนจำนวน",
                number: "จำนวนไม่ถูกต้อง",
                min: "จำนวนไม่ถูกต้อง",
                max: "ระบุจำนวนเกินที่ระบบมี",
            },
        },
        onkeyup: false,
        submitHandler: function(form) {
        	$.post('{{ url(''. $hardware->type) }}', {
        		_token: '{{ csrf_token() }}',
                id: '{{ $hardware->id }}',
                type: '{{ $hardware->type }}',
                datestart: $('#input-datestart').val(),
                datereturn: $('#input-datereturn').val(),
                quantity: $('#input-quantity').val()
        	}, function(data, textStatus, xhr) {console.log('ax');
        		if( data == 'true') {
        			swal("ส่งคำขอ", "ส่งคำขอ{{ $prefix[$hardware->type]['th'].$name[$hardware->type] }}สำเร็จ", "success");
                    $('#modal').modal('hide');
                    $("#data-table-hardware").bootgrid("reload");
        		} else {
        			swal("Error", data, "error");
        		}
        	});
        }
    });
});
</script>