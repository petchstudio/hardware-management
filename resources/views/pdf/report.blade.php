@extends('basic-template')
@section('link')
<link href="{{ asset('assets/css/pdf.css') }}" rel="stylesheet">
<link href="{{ asset('assets/fonts/kanit/kanit-light.css') }}" rel="stylesheet">
@stop

@section('container')
	<div class="wrapper-{{ $response ?: 'html' }}">
		<div class="container">
			@foreach($reports as $k => $v)
				<div class="pdf">
					<div class="text-center hide">
						<h2 class="pdf-title">รายงานคำขอใช้บริการ</h2>
					</div>

					<div class="pdf-header p-20 clearfix">
						<div class="pdf-logo">
							<img src="{{ asset('assets/images/logo-it-lg.png') }}" class="pdf-logo-img">
						</div>
						<div class="pdf-address">
							<div class="pdf-address-title">
								<strong>หลักสูตรเทคโนโลยีสารสนเทศ</strong>
							</div>
							<div>
								หลักสูตรเทคโนโลยีสารสนเทศ คณะวิทยาศาสตร์และเทคโนโลยี มหาวิทยาลัยสวนดุสิต อาคาร 11 ชั้น 3 ห้อง 11301 เลขที่ 295 ถนนนครราชสีมา เขตดุสิต กรุงเทพฯ 10300
							</div>
							<div>
								โทร. 02-244-5630 แฟกซ์. 02-244-5630
							</div>
						</div>
					</div>
				
					<div class="pdf-name p-20">
						<div class="row">
							<div class="col-xs-6">
								<div class="pdf-label">ชื่อผู้ขอ :</div>
								<div class="pdf-text">
									{{ $v['firstname'] }} {{ $v['lastname'] }}
								</div>
								<div class="pdf-label">รหัสประจำตัว :</div>
								<div class="pdf-text">
									{{ $v['sdu_id'] }}
								</div>
								<div class="pdf-label">อีเมล์ :</div>
								<div class="pdf-text">
									{{ $v['email'] }}
								</div>
							</div>
						</div>
					</div>
					<div class="pdf-requests p-r-20 p-b-20 p-l-20">
						<h2>รายการคำขอ</h2>
						<table class="pdf-table" width="100%">
							<thead>
								<tr>
									<th width="80px" style="padding: 8px; border-bottom: 2px solid #ddd;">รหัสคำขอ</th>
									<th style="padding: 8px; border-bottom: 2px solid #ddd;">ชื่ออุปกรณ์</th>
									<th width="120px" style="padding: 8px; border-bottom: 2px solid #ddd;">ชนิด</th>
									<th width="100px" style="padding: 8px; border-bottom: 2px solid #ddd;">จำนวนที่{{ $prefix[$value->request_type]['th'] }}</th>
									<th width="100px" style="padding: 8px; border-bottom: 2px solid #ddd;">วันที่ยืม</th>
									<th width="100px" style="padding: 8px; border-bottom: 2px solid #ddd;">วันที่คืน</th>
								</tr>
							</thead>
							<tbody>
								@foreach($v['requests'] as $key => $value)
									<tr>
										<td style="padding: 8px; border-top: 1px solid #ddd;">
											#{{ str_pad($value->id , 6 , '0' , STR_PAD_LEFT) }}
										</td>
										<td style="padding: 8px; border-top: 1px solid #ddd;">
											{{ $value->hardware_name }}
										</td>
										<td style="padding: 8px; border-top: 1px solid #ddd;">
											{{ $type[$value->request_type] }}
										</td>
										<td style="padding: 8px; border-top: 1px solid #ddd;">
											{{ number_format($value->quantity) }}
										</td>
										<td style="padding: 8px; border-top: 1px solid #ddd;">
											{{ date('Y-m-d', strtotime($value->datetime_start)) }}
										</td>
										<td style="padding: 8px; border-top: 1px solid #ddd;">
											{{ $value->request_type == 'material'
																		? 'ไม่มี'
																		: date('Y-m-d', strtotime($value->datetime_return))
											}}
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			@endforeach
		</div>
	</div>
@stop