@extends('page')

@section('script-plugins')
<script type = "text/javascript" >
$(document).ready(function() {
    $('#formx-register').validate({
        rules: {
            firstname: {
                required: true,
                maxlength: 255,
            },
            lastname: {
                required: true,
                maxlength: 255,
            },
            email: {
                required: true,
                maxlength: 255,
                email: true,
                remote: "{{ url('register/check-email') }}",
            },
            sduid: {
                required: true,
                number: true,
                rangelength: [4, 14],
                remote: "{{ url('register/check-sduid') }}",
            },
            password: {
                required: true,
                minlength: 6,
            },
            password_confirmation: {
                equalTo: 'input[name="password"',
            }
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
            email: {
                required: "โปรดป้อนที่อยู่อีเมล",
                maxlength: "ที่อยู่อีเมลยาวเกินไป",
                email: "รูปแบบที่อยู่อีเมลไม่ถูกต้อง",
                remote: "ที่อยู่นี้มีอยู่แล้วในระบบ",
            },
            sduid: {
                required: "โปรดระบุรหัสนักศึกษาหรือรหัสอาจารย์",
                number: "โปรดกรอกรหัสนักศึกษาหรือรหัสอาจารย์เป็นตัวเลขเท่านั้น",
                rangelength: "รหัสนักศึกษาหรือรหัสอาจารย์ไม่ถูกต้อง",
                remote: "รหัสนักศึกษาหรือรหัสอาจารย์นี้มีอยู่แล้วในระบบ",
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
    });
});
</script>
@stop


@section('content')
<div class="container">
    <div class="row m-t-30">
        <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">สมัครสมาชิก</h3>
                </div>
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <form id="form-register" method="POST" action="{{ url('register') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="firstname" placeholder="ชื่อ" value="{{ old('firstname') }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="lastname" placeholder="นามสกุล" value="{{ old('lastname') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="ion-android-call"></i></span>
                                        <input type="text" class="form-control" name="tel" placeholder="เบอร์โทรศัพท์" value="{{ old('tel') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="ion-person"></i></span>
                                        <input type="text" class="form-control" name="position" placeholder="ตำแหน่ง" value="{{ old('position') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="ion-android-mail"></i></span>
                                <input type="text" class="form-control" name="email" placeholder="ที่อยู่อีเมล" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="ion-card"></i></span>
                                <input type="text" class="form-control" name="sduid" placeholder="รหัสนักศึกษาหรือรหัสอาจารย์" value="{{ old('sduid') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="ion-locked"></i></span>
                                <input type="password" class="form-control" name="password" placeholder="รหัสผ่าน">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="ion-locked"></i></span>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="ยืนยันรหัสผ่าน">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-block btn-success">สมัครใช้งาน</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop