@extends('basic-template')

@section('container')
	<header class="nav-header">
	    <nav id="nav-top" class="navbar navbar-default navbar-fixed-top">
	        <div class="container">
	            <div class="navbar-header">
	                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
	                    <span class="sr-only">Toggle navigation</span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                </button>
	                <a class="navbar-brand" href="{{ url('/') }}" title="{{ env('SITE_NAME') }}">
	                    <img src="{{ asset('assets/images/logo-it.png') }}"> Information Technology
	                </a>
	            </div>
	            <div class="collapse navbar-collapse" id="navbar-collapse">
	                <div class="navbar-right">
	                    <p class="navbar-text">
	                        <a href="{{ url('logout') }}"{!! Request::is('/') ? ' class="active"':'' !!}>หน้าหลัก</a>
	                    </p>
	                @if( Auth::check() )
	                    <p class="navbar-text">
	                        <a href="{{ url('logout') }}">ออกจากระบบ</a>
	                    </p>
	                    <a href="{{ url('dashboard') }}" class="btn navbar-btn btn-info">จัดการบัญชี</a>
	                    @if( Auth::user()->admin() )
	                    <a href="{{ url('admin') }}" class="btn navbar-btn btn-primary">ผู้ดูแลระบบ</a>
	                    @endif
	                @else
	                    <p class="navbar-text">
	                        <a href="{{ url('login') }}"{!! Request::is('login') ? ' class="active"':'' !!}>เข้าสู่ระบบ</a>
	                    </p>
	                    <a href="{{ url('register') }}" class="btn navbar-btn btn-info">สมัครสมาชิก</a>
	                @endif
	                </div>
	            </div>
	        </div>
	    </nav>
	</header>
	<div id="container">
		<div class="clearfix">
			@yield('content')
		</div>
	</div>
@stop