<form id="form-create-hardware" class="form-horizontal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">ข้อมูลคำขอใช้งาน #{{ str_pad($request->id, 6, "0", STR_PAD_LEFT) }}</h4>
	</div>
	<div class="modal-body">

        <div class="form-group">
            <div class="col-sm-3 text-right">ชื่ออุปกรณ์</div>
            <div class="col-sm-9">{{ $request->hardware_name }}</div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-3 text-right">ยี่ห้อ</div>
            <div class="col-sm-9">{{ $request->hardware_brand }} รุ่น {{ $request->hardware_model }}</div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-3 text-right">ประเภทอุปกรณ์</div>
            <div class="col-sm-9"><span>{{ $name[$request->request_type] }}</span></div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-3 text-right">จำนวนที่ขอใช้</div>
            <div class="col-sm-9"><span>{{ $request->quantity }}</span></div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-3 control-label">สถานะ</label>
            <div class="col-sm-9">
            	<select class="selectpicker" id="input-status" name="status">
            		<option value="wait"{{ $request->status == 'wait' ? ' selected="selected"':'' }}>รออนุมัติ</option>
            		<option value="approve"{{ $request->status == 'approve' ? ' selected="selected"':'' }}>อนุมัติ</option>
            		@if ($request->request_type == 'material')
                    <option value="receive"{{ $request->status == 'receive' ? ' selected="selected"':'' }}>รับแล้ว</option>
                    @else
                    <option value="using"{{ $request->status == 'using' ? ' selected="selected"':'' }}>ใช้งาน</option>
            		<option value="return"{{ $request->status == 'return' ? ' selected="selected"':'' }}>คืนเรียบร้อย</option>
            		<option value="lost"{{ $request->status == 'lost' ? ' selected="selected"':'' }}>สูญหาย</option>
                    @endif
            	</select>
            </div>
        </div>

	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
		<button type="submit" class="btn btn-primary">บันทึก</button>
	</div>
</form>

<script type="text/javascript">
$(document).ready(function(){
	$('.selectpicker').selectpicker('refresh');

	$('#form-create-hardware').validate({
        rules: {
            status: {
                required: true,
            },
        },
        messages: {
            status: {
                required: "โปรดระบุสถานะ",
            },
        },
        onkeyup: false,
        submitHandler: function(form) {
        	$.ajax({
        		url: '{{ url('admin/request/'.$request->id) }}',
        		type: 'POST',
        		data: {
	        		_method: 'PUT',
                    _token: '{{ csrf_token() }}',
	        		id: {{ $request->id }},
	        		status: $('#input-status').val(),
        		},
        	})
        	.done(function(data) {
        		if( data == 'true') {
        			swal("แก้ไขข้อมูล", "บันทึกการแก้ไขข้อมูลสำเร็จ", "success");
        			$("#data-table-request").bootgrid("reload");
        		} else {
        			swal("Error", data, "error");
        		}
        	})
        	.fail(function(data) {
        		swal("Error", data, "error");
        	});
        }
    });
});
</script>