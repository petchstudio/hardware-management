@extends('basic-template')

@section('link')
<link href="{{ asset('assets/css/manage.css') }}" rel="stylesheet">
@stop

@section('container')
<div class="manage">
	<header class="header lt bg-dark navbar navbar-fixed-top-xs">
		<div class="navbar-header bg-dark aside-md">
			<button type="button" class="btn btn-link visible-xs" data-toggle="offcanvas" data-target="#nav" data-canvas="#content" data-autohide="false">
				<i class="fa fa-bars"></i>
			</button>
			<a href="{{ url('/') }}" class="navbar-brand">
				<img src="{{ asset('assets/images/logo-it.png') }}" class="m-r-5">
				IT PROGRAM
			</a>
			<a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user">
				<i class="fa fa-cog"></i>
			</a>
		</div>
		<ul class="nav navbar-nav navbar-right nav-user m-n hidden-xs">
			<li class="hidden-xs hidden">
				<a href="#" class="dropdown-toggle dk" data-toggle="dropdown">
					<i class="fa fa-bell"></i>
					<span class="badge">14</span>
				</a>
				<section class="dropdown-menu aside-xl">
					<section class="panel bgm-white">
						<header class="panel-heading">
							Notification
						</header>
						<ul class="list-group">
							<li class="list-group-item">
								<div class="media">
									<div class="media-left">
										<a href="#">
											<img class="media-object" src="{{ asset('assets/images/avatar/avatar_0'.rand(0,8).'.png') }}" alt="...">
										</a>
									</div>
									<div class="media-body">
										<h4 class="media-heading">Media heading</h4>
										<small>กฟหกไกฟหกฟหก</small>
									</div>
								</div>
							</li>
						</ul>
					</section>
				</section>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<span class="thumb-sm avatar pull-left">
						<img src="{{ asset('assets/images/avatar/'. Auth::user()->avatar) }}">
					</span>
					{{ Auth::user()->firstname }} <b class="caret"></b>
				</a>
				<ul class="dropdown-menu fadeInRight">
					<li>
						<a href="{{ url('account/profile') }}">ตั้งค่าบัญชี</a>
					</li>
					<li class="divider"></li>
					<li>
						<a href="{{ url('logout') }}">ออกจากระบบ</a>
					</li>
				</ul>
			</li>
		</ul>
	</header>
	<section id="container">
		<aside id="nav" class="bg-dark lter navmenu-fixed-left offcanvas">
			<ul class="nav nav-primary metismenu">
				<li{!! Request::is('dashboard*') ? ' class="active"':'' !!}>
					<a href="{{ url('dashboard') }}" aria-expanded="false">
						<i class="fa fa-dashboard"><b class="bgm-red"></b></i>
						ภาพรวม
					</a>
				</li>
				<li{!! Request::is('material*') ? ' class="active"':'' !!}>
					<a href="{{ url('material') }}" aria-expanded="true">
						<i class="fa fa-cubes"><b class="bgm-blue"></b></i>
						วัสดุ
						<i class="fa arrow"></i>
					</a>
					<ul class="nav" aria-expanded="true" role="menu">
						<li{!! Request::is('material') ? ' class="active"':'' !!}>
							<a href="{{ url('material') }}">
								<i class="fa fa-angle-right"><b class="bgm-blue"></b></i>
								<span>ประวัติการเบิก</span>
							</a>
						</li>
						<li{!! Request::is('material/requisition') ? ' class="active"':'' !!}>
							<a href="{{ url('material/requisition') }}">
								<i class="fa fa-angle-right"><b class="bgm-blue"></b></i>
								<span>เบิกวัสดุ</span>
							</a>
						</li>
					</ul>
				</li>
				<li{!! Request::is('equipment*') ? ' class="active"':'' !!}>
					<a href="{{ url('equipment') }}" aria-expanded="true">
						<i class="fa fa-pencil"><b class="bgm-deep-purple lighten-1"></b></i>
						ครุภัณฑ์
						<i class="fa arrow"></i>
					</a>
					<ul class="nav" aria-expanded="true" role="menu">
						<li{!! Request::is('equipment') ? ' class="active"':'' !!}>
							<a href="{{ url('equipment') }}">
								<i class="fa fa-angle-right"><b class="bgm-deep-purple lighten-1"></b></i>
								<span>ประวัติการยืม</span>
							</a>
						</li>
						<li{!! Request::is('equipment/borrow') ? ' class="active"':'' !!}>
							<a href="{{ url('equipment/borrow') }}">
								<i class="fa fa-angle-right"><b class="bgm-deep-purple lighten-1"></b></i>
								<span>ยืมครุภัณฑ์</span>
							</a>
						</li>
					</ul>
				</li>
				{{--<li{!! Request::is('laboratory*') ? ' class="active"':'' !!}>
					<a href="{{ url('laboratory') }}" aria-expanded="true">
						<i class="fa fa-eyedropper "><b class="bgm-orange"></b></i>
						ห้องปฏิบัติการ
						<i class="fa arrow"></i>
					</a>
					<ul class="nav" aria-expanded="true" role="menu">
						@if( Auth::user()->admin() )
						<li{!! Request::is('laboratory/calendar') ? ' class="active"':'' !!}>
							<a href="{{ url('laboratory/calendar') }}">
								<i class="fa fa-angle-right"><b class="bgm-orange"></b></i>
								<span>ปฏิทินการใช้งาน</span>
							</a>
						</li>
						@endif
						<li{!! Request::is('laboratory/log') ? ' class="active"':'' !!}>
							<a href="{{ url('laboratory/log') }}">
								<i class="fa fa-angle-right"><b class="bgm-orange"></b></i>
								<span>ประวัติการขอใช้งาน</span>
							</a>
						</li>
						<li{!! Request::is('laboratory/using') ? ' class="active"':'' !!}>
							<a href="{{ url('laboratory/using') }}">
								<i class="fa fa-angle-right"><b class="bgm-orange"></b></i>
								<span>ข้อใช้ห้องปฏิบัติการ</span>
							</a>
						</li>
					</ul>
				</li>--}}
				@if( Auth::user()->admin() )
				<li{!! Request::is('admin*') ? ' class="active"':'' !!}>
					<a href="{{ url('admin') }}" aria-expanded="true">
						<i class="fa fa-cog"><b class="bgm-pink"></b></i>
						ผู้ดูแลระบบ
						<i class="fa arrow"></i>
					</a>
					<ul class="nav" aria-expanded="true" role="menu">
						{{--<li{!! Request::is('admin/users*') ? ' class="active"':'' !!}>
							<a href="{{ url('admin/users') }}">
								<i class="fa fa-angle-right"><b class="bgm-pink"></b></i>
								<span>จัดการผู้ใช้</span>
							</a>
						</li>--}}
						<li{!! Request::is('admin/request*') ? ' class="active"':'' !!}>
							<a href="{{ url('admin/request') }}">
								<i class="fa fa-angle-right"><b class="bgm-pink"></b></i>
								<span>จัดการคำขอใช้บริการ</span>
							</a>
						</li>
						<li{!! Request::is('admin/material*') ? ' class="active"':'' !!}>
							<a href="{{ url('admin/material') }}">
								<i class="fa fa-angle-right"><b class="bgm-pink"></b></i>
								<span>จัดการวัสดุ</span>
							</a>
						</li>
						<li{!! Request::is('admin/equipment*') ? ' class="active"':'' !!}>
							<a href="{{ url('admin/equipment') }}">
								<i class="fa fa-angle-right"><b class="bgm-pink"></b></i>
								<span>จัดการครุภัณฑ์</span>
							</a>
						</li>
						{{--<li{!! Request::is('admin/laboratory*') ? ' class="active"':'' !!}>
							<a href="{{ url('admin/laboratory') }}">
								<i class="fa fa-angle-right"><b class="bgm-pink"></b></i>
								<span>จัดการห้องปฏิบัติการ</span>
							</a>
						</li>--}}
					</ul>
				</li>
				@endif
				<li{!! Request::is('account*') ? ' class="active"':'' !!}>
					<a href="{{ url('account') }}" aria-expanded="true">
						<i class="fa fa-cog"><b class="bgm-green"></b></i>
						จัดการบัญชี
						<i class="fa arrow"></i>
					</a>
					<ul class="nav" aria-expanded="true" role="menu">
						<li{!! Request::is('account/profile') ? ' class="active"':'' !!}>
							<a href="{{ url('account/profile') }}">
								<i class="fa fa-angle-right"><b class="bgm-green"></b></i>
								<span>ข้อมูลส่วนตัว</span>
							</a>
						</li>
						<li{!! Request::is('account/change-password') ? ' class="active"':'' !!}>
							<a href="{{ url('account/change-password') }}">
								<i class="fa fa-angle-right"><b class="bgm-green"></b></i>
								<span>เปลี่ยนรหัสผ่าน</span>
							</a>
						</li>
						{{--<li{!! Request::is('account/change-email') ? ' class="active"':'' !!}>
							<a href="{{ url('account/change-email') }}">
								<i class="fa fa-angle-right"><b class="bgm-green"></b></i>
								<span>เปลี่ยนอีเมล</span>
							</a>
						</li>--}}
					</ul>
				</li>
			</ul>
			<div class="nav-footer">
				<a href="#nav" data-toggle="class:nav-xs" class="pull-right btn btn-sm btn-dark btn-icon hide">
					<i class="fa fa-angle-left text"></i>
					<i class="fa fa-angle-right text-active"></i>
				</a>
				<div class="btn-group pull-right">
					<a title="ออกจากระบบ" href="{{ url('logout') }}" class="btn btn-icon btn-sm btn-dark"><i class="fa fa-power-off"></i></a>
				</div>
			</div>
		</aside>
		<div id="content">
			<div class="clearfix">
				<div class="container-fluid">@yield('content')</div>
			</div>
		</div>
	</section>
</div>
@stop