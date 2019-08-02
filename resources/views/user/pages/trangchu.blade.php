@extends('user.layout.index')
@section('content')
	<!-- HOME -->
	<script type="text/javascript">
		function checkthue(){
			return alert("Ban phai dang nhap!");
		}

		function thongbaotrutien(){
			return alert("Bạn sẽ bị trừ tiền trong tài khoản.Nếu có thắc mắc hãy đọc lại chính sách nhé! Cám ơn bạn. ");
		}

	</script>
	<div id="home">
		<!-- container -->
		<div class="container">
			<!-- home wrap -->
			<div class="home-wrap">
				<!-- home slick -->
				@if(count($errors)>0)
	                  <div class="alert alert-danger">
	                    @foreach($errors->all() as $err)
	                      <h5>{{$err}}</h5>
	                    @endforeach
	                  </div>
	                @endif
				<div id="home-slick">

					<!-- banner -->
					<div class="banner banner-1">
						<img src="frontend/img/slide/banner1.jpg" alt="">
						<!-- <div class="banner-caption text-center">
							<h1>Giảm giá sốc 50%</h1>
							<h3>Từ ngày 11/7 - 19/7</h3>
							<button class="primary-btn">Đọc ngay</button>
						</div> -->
					</div>
					<!-- /banner -->

					<!-- banner -->
					<div class="banner banner-1">
						<img src="frontend/img/slide/banner2.png" alt="">
						<!-- <div class="banner-caption">
							<h1 class="primary-color"><br>
								LUẬN VĂN
								<span class="white-color font-weak">Giảm 50% khi có thẻ sinh viên</span>
							</h1>

							<button class="primary-btn">Đọc ngay</button>
						</div> -->
					</div>
					<!-- /banner -->
				</div>
				<!-- /home slick -->
			</div>
			<!-- /home wrap -->
		</div>
		<!-- /container -->
	</div>
	<!-- /HOME -->

	<br>

	<!-- section -->
	<div class="section section-grey">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<div class="qoute">"Họ cười tôi vì tôi khác họ <br> Tôi cười họ vì họ quá giống nhau."<br>---Joker.</div>
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->

	<!-- section -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<!-- section-title -->
				<div class="col-md-12">
					
					<div class="section-title">
						<h2 class="title">SÁCH MIỄN PHÍ</h2>
						<div class="pull-right">
							<div class="product-slick-dots-1 custom-dots"></div>
						</div>
					</div>
					<div><i>Có {{count($free_ebook)}} ebook miễn phí.</i></div>
				</div>
				<!-- /section-title -->

				<!-- banner -->
				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="banner banner-2">
						<img src="frontend/img/banner-sach.jpg" alt="">
						<div class="banner-caption">
							<h2 class="white-color">SÁCH<br>MIỄN PHÍ</h2>
							<a href="ebook"><button class="primary-btn">Xem tất cả</button></a>
						</div>
					</div>
				</div>
				<!-- /banner -->

				<!-- Product Slick -->
				<div class="col-md-9 col-sm-6 col-xs-6">
					<div class="row">
						<div id="product-slick-1" class="product-slick">
							@foreach($free_ebook as $free)
								<!-- Product Single -->
								<div class="product product-single" style="height:500px">
									<div class="product-thumb">
										<div class="product-label">
											<span class="sale">Miễn phí</span>
										</div>
										
										<a href="{{route('chitietebook',$free->id)}}"><button class="main-btn quick-view"><i class="fa fa-search-plus"></i> Đọc thử</button></a>
										<img src="upload/ebook/{{$free->image}}" alt="" height="300px">
									</div>
									<div class="product-body">
										<h3 class="product-price">{{number_format($free->hire_price)}} Xu</h3>
										<!-- <div class="product-rating">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star-o empty"></i>
										</div> -->
										<h2 class="product-name"><a href="{{route('chitietebook',$free->id)}}">{{$free->name}}</a></h2>
										
										<div class="product-btns">
											@if(Auth::check())
											<form action="themthuvien/{{$free->id}}" method="post">
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
								<!-- /Product Single -->
							@endforeach				
						</div>
					</div>
				</div>
				<!-- /Product Slick -->
			</div>
			<!-- /row -->


			<!-- row -->
			<div class="row">
				<!-- section title -->
				<div class="col-md-12">
					<div class="section-title">
						<h2 class="title">SÁCH MỚI</h2>
					</div>
					<div><i>Có {{count($new_ebook)}} ebook mới.</i></div>
				</div>
				<!-- section title -->
				
				@foreach($new_ebook as $new)
				<!-- Product Single -->
				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="product product-single" style="height:500px">
						<div class="product-thumb">
							<a href="{{route('chitietebook',$new->id)}}"><button class="main-btn quick-view"><i class="fa fa-search-plus"></i> Đọc thử</button></a>
							<img src="upload/ebook/{{$new->image}}" alt="" height="300px">
						</div>
						<div class="product-body">
							<h3 class="product-price">{{number_format($new->hire_price)}} Xu</h3>
							<!-- <div class="product-rating">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star-o empty"></i>
							</div> -->
							<h2 class="product-name"><a href="{{route('chitietebook',$new->id)}}">{{$new->name}}</a></h2>
							<div class="product-btns">
								@if(Auth::check())
								<form action="themthuvien/{{$new->id}}" method="post">
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
			<!-- /row -->
			
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->

	<!-- section -->
	<div class="section section-grey">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<div class="qoute">"Họ cười tôi vì tôi khác họ <br> Tôi cười họ vì họ quá giống nhau."<br>---Joker.</div>
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->

	<!-- section -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<!-- section title -->
				<div class="col-md-12">
					<div class="section-title">
						<h2 class="title">THUÊ NHIỀU NHẤT</h2>
					</div>
					<div><i>Có {{count($view_ebook)}} ebook được thuê nhiều nhất.</i></div>
				</div>
				<!-- section title -->
				
				@foreach($view_ebook as $view)
				<!-- Product Single -->
				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="product product-single" style="height:500px">
						<div class="product-thumb">
							<a href="{{route('chitietebook',$view->id)}}"><button class="main-btn quick-view"><i class="fa fa-search-plus"></i> Đọc thử</button></a>
							<img src="upload/ebook/{{$view->image}}" alt="" height="300px">
						</div>
						<div class="product-body">
							<h3 class="product-price">{{number_format($view->hire_price)}} Xu</h3>
							<!-- <div class="product-rating">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star-o empty"></i>
							</div> -->
							<h2 class="product-name"><a href="{{route('chitietebook',$view->id)}}">{{$view->name}}</a></h2>
							<div class="product-btns">
								@if(Auth::check())
								<form action="themthuvien/{{$view->id}}" method="post">
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
			<!-- /row -->

		</div>
		<!-- /container -->
	</div>
	<!-- /section -->
@endsection