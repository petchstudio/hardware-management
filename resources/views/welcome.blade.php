@extends('page')

@section('content')
    <div id="welcome-banner">
        <div class="container">
            <div class="welcome-banner-content">
                <h1 class="welcome-banner-title">การพัฒนาฐานข้อมูลครุภัณฑ์ออนไลน์</h1>
                <p class="welcome-banner-text">
                    บริการตรวจสอบ เบิก ยืม คืน ครุภัณฑ์ของหลักสูตรเทคโนโลยีสารสนเทศ สำหรับนักศึกษา บุคลากร มหาวิทยาลัยสวนดุสิต
                </p>
                <div class="welcome-banner-btn">
                    <a class="btn btn-xxl btn-thsarabun btn-plain-alt btn-requisition" href="{{ url('material/requisition') }}">เบิกวัสดุ</a>
                    <a class="btn btn-xxl btn-thsarabun btn-plain-alt btn-borrow" href="{{ url('equipment/borrow') }}">ยืมครุภัณฑ์</a>
                    {{--<a class="btn btn-xxl btn-thsarabun btn-plain-alt btn-using" href="{{ url('laboratory/using') }}">ขอใช้ห้องปฏิบัติการ</a>--}}
                </div>
            </div>
            @if( Auth::guest() )
            <div class="welcome-banner-register">
                <h1 class="welcome-banner-title">เข้าสู่ระบบ</h1>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif
                <form method="POST" action="{{ url('register') }}" class="hide">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="firstname" placeholder="ชื่อ" value="{{ old('firstname') }}">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="lastname" placeholder="นามสกุล" value="{{ old('lastname') }}">
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
                @include('auth.login_form')
            </div>
            @endif
        </div>
    </div>
@stop