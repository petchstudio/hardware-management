@extends('manage')

@section('script-plugins')
<script src="{{ asset('assets/js/plugins/bootstrap-sweetalert/lib/sweet-alert.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery-validation/1.14.0/dist/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/validate.js') }}"></script>
<script type = "text/javascript" >
$(document).ready(function() {
    $('#form-profile').validate({
        rules: {
            firstname: {
                required: true,
                maxlength: 255,
            },
            lastname: {
                required: true,
                maxlength: 255,
            },
            sduid: {
                required: true,
                number: true,
                rangelength: [4, 14],
                remote: "{{ url('account/check-sduid') }}",
            },
        },
        messages: {
            firstname: {
                required: "โปรดป้อนชื่อ",
                maxlength: "ชื่อมีความยาวมากเกินไป"
            },
            lastname: {
                required: "โปรดป้อนนามสกุล",
                maxlength: "นามสกุลมีความยาวมากเกินไป"
            },
            sduid: {
                required: "โปรดระบุรหัสนักศึกษาหรือรหัสอาจารย์",
                number: "โปรดกรอกรหัสนักศึกษาหรือรหัสอาจารย์เป็นตัวเลขเท่านั้น",
                rangelength: "รหัสนักศึกษาหรือรหัสอาจารย์ไม่ถูกต้อง",
                remote: "รหัสนักศึกษาหรือรหัสอาจารย์นี้มีอยู่แล้วในระบบ",
            },
        },
        onkeyup: false,
        submitHandler: function(form) {
            //console.log('{{ url('account/profile/'.Auth::user()->id) }}');
            $.ajax({
                url: '{{ url('account/profile/'.Auth::user()->id) }}',
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    firstname: $('#input-firstname').val(),
                    lastname: $('#input-lastname').val(),
                    sduid: $('#input-sduid').val(),
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
            <div class="panel-title">ข้อมูลส่วนตัว</div>
        </div>
        <form id="form-profile">
            <div class="panel-body">
            
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="input-firstname">ชื่อ</label>
                            <input type="text" class="form-control" name="firstname" id="input-firstname" value="{{ Auth::user()->firstname }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="input-lastname">นามสกุล</label>
                            <input type="text" class="form-control" name="lastname" id="input-lastname" value="{{ Auth::user()->lastname }}">
                        </div>
                    </div>

                </div>
                
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="input-tel">เบอร์โทรศัพท์</label>
                            <input type="text" class="form-control" name="tel" id="input-tel" value="{{ Auth::user()->tel }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="input-position">ตำแหน่ง</label>
                            <input type="text" class="form-control" name="position" id="input-position" value="{{ Auth::user()->position }}">
                        </div>
                    </div>

                </div>
                
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="input-sduid">รหัสนักศึกษาหรือรหัสบุคลากร</label>
                            <input type="text" class="form-control" name="sduid" id="input-sduid" value="{{ Auth::user()->sdu_id }}">
                        </div>
                    </div>

                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-success">บันทึก</button>
                </div>
            
            </div>
        </form>
    </div>
@stop