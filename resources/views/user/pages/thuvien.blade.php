@extends('user.layout.index')
@section('content')

<!-- section -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<form id="checkout-form" class="clearfix">
					<div class="col-md-12">
						<div class="order-summary clearfix">
							@if(session('thongbao'))
			                  <div class="alert alert-danger">{{session('thongbao')}}</div>
			                @endif
							<div class="section-title">
								<h3 class="title">THƯ VIỆN CỦA BẠN</h3>
							</div>
			                
							<div><i>Có {{count(Auth::user()->library)}} ebook trong thư viện của bạn.</i></div><br>
							<table class="shopping-cart-table table">
								<thead style="background-color: #F8694A">
									<tr>
										<th></th>
										<th>EBOOK</th>
										<th class="text-center">giá thuê mỗi ngày</th>
										<th class="text-right"></th>
									</tr>
								</thead>
								<tbody>
									@foreach(Auth::user()->library as $v)
										@if(in_array($v->id,$dsebook))
				                          <tr>
											<td class="thumb"><img src="upload/ebook/{{$v->image}}" alt=""></td>
											<td class="details">
												<a href="{{url('doc', ['id' => $v->id, 'pageNum' => $v->bookmark]) }}">{{$v->name}}</a>
												{{--<a href="testpdf">{{$v->name}}</a>--}}
											</td>
											<td class="price text-center"><strong>{{number_format($v->hire_price)}}</strong></td>
										  </tr>
										@else
										  <tr style="background-color: #A9A9A9">
											<td class="thumb"><img src="upload/ebook/{{$v->image}}" alt=""></td>
											<td class="details">
												<a href="{{url('doc', ['id' => $v->id, 'pageNum' => $v->bookmark]) }}">{{$v->name}}</a>
												{{--{{$v->name}}--}}
											</td>
											<td class="price text-center"><strong>{{number_format($v->hire_price)}}</strong></td>
											
											<td class="text-right"><a class="primary-btn" href="xoathuvien/{{$v->id}}">Trả ebook</a><a class="primary-btn" href="chitietebook/{{$v->id}}">Tiep tuc thue</a></td>
										  </tr>
										@endif
			                        @endforeach
									
								</tbody>
							</table>
							
							<div class="section-title">
								<h3 class="title">LỊCH SỬ THUÊ CỦA BẠN</h3>
							</div>
			                
							<div><i>Bạn đã thuê {{count(Auth::user()->hire)}} ebook.</i></div><br>
							<table class="shopping-cart-table table">
								<thead style="background-color: #F8694A">
									<tr>
										<th></th>
										<th>EBOOK</th>
										<th class="text-center">giá thuê mỗi ngày</th>
										<th class="text-center">Ngày thuê</th>
										<th class="text-center">Ngày kết thúc</th>
										<th class="text-center">Xu đã trả</th>
									</tr>
								</thead>
								<tbody>
									@foreach(Auth::user()->hire as $v)
			                          <tr>
										<td class="thumb"><img src="upload/ebook/{{$v->image}}" alt=""></td>
										<td class="details">
											{{$v->name}}
										</td>
										
										<td class="price text-center"><strong>{{number_format($v->hire_price)}}</strong></td>
										<td class="price text-center"><strong>{{$v->pivot->date_start}}</strong></td>
										<td class="price text-center"><strong>{{$v->pivot->date_end}}</strong></td>
										<td class="total text-center"><strong class="primary-color">{{$v->pivot->total_price}}</strong></td>
									</tr>
			                        @endforeach
									
								</tbody>
							</table>
						</div>

					</div>
				</form>
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->
@endsection