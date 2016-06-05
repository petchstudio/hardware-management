<form id="form-create-hardware">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">แก้ไขข้อมูล #{{ str_pad($hardware->id, 4, "0", STR_PAD_LEFT) }}</h4>
	</div>
	<div class="modal-body">

		<div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="input-hardware">รหัส{{ $name[$type] }}</label>
                    <input type="text" class="form-control" id="input-hardware" name="hardware">
                </div>
            </div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="input-name">ชื่อ{{ $name[$hardware->type] }}</label>
					<input type="text" class="form-control" id="input-name" name="name" value="{{ $hardware->name }}">
				</div>
			</div>
		</div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="input-brand">ยี่ห้อ</label>
                    <input type="text" class="form-control" id="input-brand" name="brand">
                    {{--<select id="input-brand" name="brand" class="selectpicker" data-width="100%">
                        @foreach( $brands as $key => $value)
                            <option value="{{ $value->id }}"{!! $hardware->brand_id == $value->id ? ' selected="selected"':'' !!}>{{ $value->name }}</option>
                        @endforeach
                    </select>--}}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="input-model">รุ่น</label>
                    <input type="text" class="form-control" id="input-model" name="model" value="{{ $hardware->model }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="input-place">สถานที่เก็บ</label>
                    <select id="input-place" name="place" class="selectpicker" data-width="100%">
                        <option value="1"{!! $hardware->place_id == 1 ? ' selected="selected"':'' !!}>ห้องหลักสูตร</option>
                        <option value="2"{!! $hardware->place_id == 2 ? ' selected="selected"':'' !!}>ห้องปฏิบัติการ</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="input-status">สถานะ</label>
                    <select id="input-status" name="status" class="selectpicker" data-width="100%">
                        <option value="0"{!! $hardware->status == 0 ? ' selected="selected"':'' !!}>ปกติ</option>
                        <option value="1"{!! $hardware->status == 1 ? ' selected="selected"':'' !!}>เสีย</option>
                    </select>
                </div>
            </div>
        </div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="input-category">ประเภท</label>
					<select id="input-category" name="category" class="selectpicker" data-width="100%">
						@foreach( $categorys as $key => $value)
						<option value="{{ $value->id }}"{{!! $value->id == $hardware->category_id ? ' selected="selected"':'' !!}}>{{ $value->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="input-get-at">รับเข้าระบบเมื่อ</label>
                    <input type="text" class="form-control datepicker" id="input-get-at" name="get_at" value="{{ Carbon\Carbon::parse($hardware->get_at)->format('d/m/Y') }}">
                </div>
            </div>
        </div>

        <div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="input-quantity">จำนวน</label>
					<input type="number" class="form-control" id="input-quantity" name="quantity" value="{{ $hardware->quantity }}">
				</div>
			</div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="input-responsible">ผู้รับผิดชอบ</label>
                    <select id="input-responsible" name="responsible" class="selectpicker" data-width="100%">
                        <option value="ผศ.ดร.ฐิติยา เนตรวงษ์">ผศ.ดร.ฐิติยา เนตรวงษ์</option>
                        <option value="ผศ.ดร.พรรณี สวนเพลง">ดร.พรรณี สวนเพลง</option>
                        <option value="อ.เขมขนิษฐ์ แสนยะนันท์ธนะ">อ.เขมขนิษฐ์ แสนยะนันท์ธนะ</option>
                        <option value="อ.ชูติวรรณ บุญอาชาทอง">อ.ชูติวรรณ บุญอาชาทอง</option>
                        <option value="อ.อัฐเดช วรรณสิน">อ.อัฐเดช วรรณสิน</option>
                        <option value="อ.กิ่งกาญจน์ ทองงอก">อ.กิ่งกาญจน์ ทองงอก</option>
                        <option value="ดร.สุระสิทธิ์ ทรงม้า">ดร.สุระสิทธิ์ ทรงม้า</option>
                        <option value="อ.ภูริพจน์ แก้วย่อง">อ.ภูริพจน์ แก้วย่อง</option>
                        <option value="อ.ทินกร ชุณหภัทรกุล">อ.ทินกร ชุณหภัทรกุล</option>
                        <option value="อ.วัชรากรณ์ เนตรหาญ">อ.วัชรากรณ์ เนตรหาญ</option>
                        <option value="อ.ศัชชญาส์ ดวงจันทร์">อ.ศัชชญาส์ ดวงจันทร์</option>
                        <option value="อ.ณรงค์ฤทธิ์ ภิรมย์นก">อ.ณรงค์ฤทธิ์ ภิรมย์นก</option>
                    </select>
                </div>
            </div>
		</div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="input-note">หมายเหตุ</label>
                    <input type="text" class="form-control" id="input-note" name="note" value="{{ $hardware->note }}">
                </div>
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
    $('.datepicker').datepicker({
        format: "dd/mm/yyyy",
        todayBtn: "linked",
        language: "th",
        todayHighlight: true,
    });

	$('.selectpicker').selectpicker('refresh');

	$('#form-create-hardware').validate({
        rules: {
            name: {
                required: true,
            },
            category: {
                required: true,
            },
            quantity: {
                required: true,
                number: true,
                min: 0,
            },
        },
        messages: {
            name: {
                required: "โปรดป้อนชื่อ",
            },
            category: {
                required: "โปรดเลือกประเภท",
            },
            quantity: {
                required: "โปรดป้อนจำนวน",
                number: "จำนวนไม่ถูกต้อง",
                min: "จำนวนไม่ถูกต้อง",
            },
        },
        onkeyup: false,
        submitHandler: function(form) {
        	$.ajax({
        		url: '{{ url('admin/'.$hardware->type.'/'.$hardware->id) }}',
        		type: 'POST',
        		data: {
                    _method: 'PUT',
	        		_token: '{{ csrf_token() }}',
                    hardware_id: $('#input-hardware').val(),
	        		name: $('#input-name').val(),
	                brand: $('#input-brand').val(),
	                model: $('#input-model').val(),
                    responsible: $('#input-responsible').val(),
	                place: $('#input-place').val(),
	                status: $('#input-status').val(),
	        		category: $('#input-category option:selected').val(),
	                quantity: $('#input-quantity').val(),
                    note: $('#input-note').val(),
	                get_at: $('#input-get-at').val()
        		},
        	})
        	.done(function(data) {
        		if( data == 'true') {
        			swal("แก้ไขข้อมูล", "บันทึกการแก้ไขข้อมูลสำเร็จ", "success");
        			$("#data-table-hardware").bootgrid("reload");
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