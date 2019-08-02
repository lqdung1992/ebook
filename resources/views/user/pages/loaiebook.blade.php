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
			<!-- row -->
			<div class="row">
				<!-- section title -->
				<div class="col-md-12">
					<div class="section-title">
						<h2 class="title">TẤT CẢ SÁCH</h2>
					</div>
					<div><i>Có tất cả {{count($ebook)}} ebook.</i></div>
				</div>
				<!-- section title -->
				
				@foreach($ebook as $e)
				<!-- Product Single -->
				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="product product-single" style="height:500px">
						<div class="product-thumb">
							<a href="{{route('chitietebook',$e->id)}}"><button class="main-btn quick-view"><i class="fa fa-search-plus"></i> Đọc thử</button></a>
							<img src="upload/ebook/{{$e->image}}" alt="" height="300px" >
						</div>
						<div class="product-body">
							<h3 class="product-price">{{$e->hire_price}} Xu</h3>
							<!-- <div class="product-rating">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star-o empty"></i>
							</div> -->
							<h2 class="product-name"><a href="#">{{$e->name}}</a></h2>
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
				
			</div>
			
			<!-- row -->
			<div class="row">
				<!-- section title -->
				<div class="col-md-12">
					<div class="section-title">
						<h2 class="title">CÁC SÁCH KHÁC</h2>
					</div>
					<div><i>Có tất cả {{count($ebook_khac)}} ebook khác.</i></div>
				</div>
				<!-- section title -->
				
				@foreach($ebook_khac as $khac)
				<!-- Product Single -->
				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="product product-single" style="height:500px">
						<div class="product-thumb">
							<a href="{{route('chitietebook',$khac->id)}}"><button class="main-btn quick-view"><i class="fa fa-search-plus"></i> Đọc thử</button></a>
							<img src="upload/ebook/{{$khac->image}}" alt="" height="300px" >
						</div>
						<div class="product-body">
							<h3 class="product-price">{{$khac->hire_price}} Xu</h3>
							<!-- <div class="product-rating">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star-o empty"></i>
							</div> -->
							<h2 class="product-name"><a href="#">{{$khac->name}}</a></h2>
							<div class="product-btns">
								@if(Auth::check())
								<form action="themthuvien/{{$khac->id}}" method="post">
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




				
			</div>
		<!-- /container -->
	</div>
	<!-- /section -->

@endsection