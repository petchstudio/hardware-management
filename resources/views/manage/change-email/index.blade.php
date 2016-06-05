@extends('manage')

@section('script-plugins')
<script src="{{ asset('assets/js/plugins/bootstrap-sweetalert/lib/sweet-alert.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery-validation/1.14.0/dist/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/validate.js') }}"></script>
<script type = "text/javascript" >
$(document).ready(function() {
    $('#form-change-password').validate({
        rules: {
            old_password: {
                //required: true,
            },
            password: {
                required: true,
                minlength: 6,
            },
            password_confirmation: {
                required: true,
                equalTo: 'input[name="password"',
            }
        },
        messages: {
            old_password: {
                required: "โปรดระบุรหัสผ่านเดิม",
            },
            password: {
                required: "โปรดระบุรหัสผ่าน",
                minlength: "รหัสผ่านต้องมีความยาวไม่น้อยกว่า 6 ตัวอักษร",
            },
            password_confirmation: {
                required: "โปรดยืนยันรหัสผ่าน",
                equalTo: "รหัสผ่านไม่ตรงกัน",
            }
        },
        onkeyup: false,
        submitHandler: function(form) {
            $.ajax({
                url: '{{ url('account/change-password/'.Auth::user()->id) }}',
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    old_password: $('#input-input-old-password').val(),
                    password: $('#input-password').val(),
                    password_confirmation: $('#input-password-confirmation').val(),
                },
            })
            .done(function(data) {
                if( data == 'true') {
                    swal("แก้ไขข้อมูล", "แก้ไขข้อมูลสำเร็จ", "success");
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
@stop

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">เปลี่ยนรหัสผ่าน</div>
        </div>
        <form id="form-change-password">
            <div class="panel-body">
            
                <div class="form-group hide">
                    <input type="password" class="form-control" id="input-old-password" name="old_password" placeholder="รหัสผ่านเดิม">
                </div>
            
                <div class="form-group">
                    <input type="password" class="form-control" id="input-password" name="password" placeholder="รหัสผ่าน">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="input-password-confirmation" name="password_confirmation" placeholder="ยืนยันรหัสผ่าน">
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-success">บันทึก</button>
                </div>
            
            </div>
        </form>
    </div>
@stop