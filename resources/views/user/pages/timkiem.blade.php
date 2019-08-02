@extends('user.layout.index')
@section('content')
	<!-- HOME -->
	<div id="home">
		<!-- container -->
		<div class="container">
			
		</div>
		<!-- /container -->
	</div>
	<!-- /HOME -->

	<br>

	

	<!-- section -->
	<div class="section">
		<!-- container -->
		<div class="container">
			
			<?php 
				function doimau($str, $tukhoa){
					return str_replace($tukhoa,"<span style='color:red'>$tukhoa</span>",$str);
				}
			?>
			<!-- row -->
			<div class="row">
				<!-- section title -->
				<div class="col-md-12">
					<div class="section-title">
						<h2 class="title">TÌM KIẾM TỪ KHÓA: {{$tukhoa}} </h2>
					</div>
					<div><i>Có tất cả {{count($kqtim)}} kết quả được tìm thấy.</i></div>
				</div>
					@foreach($errors->all() as $err)
										<h5>{{$err}}</h5>
									@endforeach
				 	@if(session('thongbao'))
	                  <div class="alert alert-danger">
	                    {{session('thongbao')}}
	                </div>
	                @endif
				<!-- section title -->

				@if($danhmuc == 0)
					@if(count($kqtim)>0)
						<!-- Product Slick -->
							
										@foreach($kqtim as $e)
											<!-- Product Single -->
											<div class="col-md-3 col-sm-6 col-xs-6">
												<div class="product product-single" style="height:500px">
													<div class="product-thumb">
														<a href="{{route('chitietebook',$e->id)}}"><button class="main-btn quick-view"><i class="fa fa-search-plus"></i> Đọc thử</button></a>
														<img src="upload/ebook/{{$e->image}}" alt="" height="300px">
													</div>
													<div class="product-body">
														<h3 class="product-price">{{number_format($e->hire_price)}} Xu</h3>
														<!-- <div class="product-rating">
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star-o empty"></i>
														</div> -->
														<h2 class="product-name"><a href="{{route('chitietebook',$e->id)}}">{{$e->name}}</a></h2>
														<div class="product-btns">
															@if(Auth::check())
															<form action="themthuvien/{{$e->id}}" method="post">
																<input type="hidden" name="_token" value="{{csrf_token()}}">
																<button class="primary-btn add-to-cart" onclick="thongbaotrutien()" style="width: 70px" value="1" name="ngaythue" type="submit">1 ngày </button>
																<button class="primary-btn add-to-cart" onclick="thongbaotrutien()" style="width: 70px" name="ngaythue" value="7">7 ngày </button>
																<button class="primary-btn add-to-cart" onclick="thongbaotrutien()" style="width: 70px" name="ngaythue" value="30">30 ngày </button>
															</form>
															
															@else 
															<a href="dangnhap"><button class="primary-btn add-to-cart"><i class="fa fa-exchange"></i> Đăng nhập để thuê </button></a>
															@endif
														</div>
													</div>
												</div>
											</div>
											<!-- /Product Single -->
										@endforeach				
									
							<!-- /Product Slick -->
					@endif
				@endif
				@if($danhmuc == 1)
					@if(count($kqtim)>0)
						@foreach($kqtim as $e)
						<!-- Product Single -->
						<div class="col-md-3 col-sm-6 col-xs-6">
							<div><a href="#"><h3>{{$e->name}}</h3></a></div>
						</div>
						<!-- /Product Single -->
						@endforeach	
					@endif
				@endif
				@if($danhmuc == 2)
					@if(count($kqtim)>0)
						@foreach($kqtim as $e)
						<!-- Product Single -->
						<div class="col-md-3 col-sm-6 col-xs-6">
							<div><a href="#"><h3>{{$e->name}}</h3></a></div>
						</div>
						<!-- /Product Single -->
						@endforeach	
					@endif
				@endif
				@if($danhmuc == 3)
					@if(count($kqtim)>0)
						@foreach($kqtim as $e)
						<!-- Product Single -->
						<div class="col-md-3 col-sm-6 col-xs-6">
							<div><a href="#"><h3>{{$e->name}}</h3></a></div>
						</div>
						<!-- /Product Single -->
						@endforeach	
					@endif
				@endif
				@if($danhmuc == 4)
					@if(count($kqtim)>0)
						@foreach($kqtim as $e)
						<!-- Product Single -->
						<div class="col-md-3 col-sm-6 col-xs-6">
							<div><a href="#"><h3>{{$e->name}}</h3></a></div>
						</div>
						<!-- /Product Single -->
						@endforeach	
					@endif
				@endif
				
			</div>
			
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->

@endsection