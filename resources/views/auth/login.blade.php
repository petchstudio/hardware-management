@extends('page')

@section('content')
<div class="container">
    <div class="row m-t-30">
        <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">เข้าสู่ระบบ</h3>
                </div>
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    @include('auth.login_form')
                </div>
            </div>
        </div>
    </div>
</div>
@stop