<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>การพัฒนาฐานข้อมูลครุภัณฑ์ออนไลน์ - สาขาเทคโนโลยีสารสนเทศ มหาวิทยาลัยสวนดุสิต</title>

		@include('includes.link')

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="wraper">
			@yield('container')
		</div>
		
		@include('includes.script')
		@section('script')@show
		@include('includes.modal')
	</body>
</html>