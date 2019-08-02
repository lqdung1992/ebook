@extends('user.layout.index')
@section('content')
	<script type="text/javascript">
		function checkthue(){
			return alert("Ban phai dang nhap!");
		}

		function thongbaotrutien(){
			return alert("Bạn sẽ bị trừ tiền trong tài khoản, và sẽ được gia hạn vào 24h00. Hãy đọc lại chính sách nhé! Cám ơn bạn. ");
		}

	</script>
	<br>

	<!-- BREADCRUMB -->
	<div id="breadcrumb">
		<div class="container">
			<ul class="breadcrumb">
				<li><a href="trangchu">Trang chủ</a></li>
				<li><a href="ebook">Sách</a></li>
				<li class="active">Chi tiết</li>
			</ul>
		</div>
	</div>
	<!-- /BREADCRUMB -->

	<!-- section -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<!--  Product Details -->
				<div class="product product-details clearfix">
					<div class="col-md-4">
						<div id="product-main-view">
							<div class="product-view">
								<img src="upload/ebook/{{$ebook->image}}" alt="">
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="product-body">
							@if($ebook->hire_price == 0)
							<div class="product-label">
								<span class="sale">Miễn phí</span>
							</div>
							@endif
							@if($ebook->new == 0)
								<div class="product-label">
								<span class="sale">Mới</span>
							</div>
							@endif
							<h2 class="product-name">{{$ebook->name}}</h2>
							<h3 class="product-price">{{number_format($ebook->hire_price)}} Xu</h3>
							<div>
								<!-- <strong>Xếp hạng:</strong> {{$ebook->rate}}/ 5 
								<div class="product-rating">
									<i class="fa fa-star"></i>
								</div> -->
								
							</div>
							<p><strong>Tác giả:</strong>
							@foreach($ebook->author_ebook as $e) 
								- {{$e->name}}
							@endforeach </p>
							<p><strong>Thể loại:</strong>
							@foreach($ebook->type_ebook as $e) 
								{{$e->name}}
							@endforeach </p>
							<p><strong>Tóm tắt: </strong>{{$ebook->description}} </p>

							<div class="product-btns">
								@if(Auth::check())
								<form action="themthuvien/{{$ebook->id}}" method="post">
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
					<!-- <div class="col-md-12">
						<div class="product-tab">
							<ul class="tab-nav">
								<li class="active"><a data-toggle="tab" href="#tab1">Mô tả</a></li>
								<li><a data-toggle="tab" href="#tab2">Bình luận</a></li>
							</ul>
							<div class="tab-content">
								<div id="tab1" class="tab-pane fade in active">
									<p>{{$ebook->description}}</p>
								</div>
								<div id="tab2" class="tab-pane fade in">

									<div class="row">
										<div class="col-md-6">
											<div class="product-reviews">
												<div class="single-review">
													<div class="review-heading">
														<div><a href="#"><i class="fa fa-user-o"></i> John</a></div>
														<div><a href="#"><i class="fa fa-clock-o"></i> 27 DEC 2017 / 8:0 PM</a></div>
														<div class="review-rating pull-right">
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star-o empty"></i>
														</div>
													</div>
													<div class="review-body">
														<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Duis aute
															irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
													</div>
												</div>

												<div class="single-review">
													<div class="review-heading">
														<div><a href="#"><i class="fa fa-user-o"></i> John</a></div>
														<div><a href="#"><i class="fa fa-clock-o"></i> 27 DEC 2017 / 8:0 PM</a></div>
														<div class="review-rating pull-right">
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star-o empty"></i>
														</div>
													</div>
													<div class="review-body">
														<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Duis aute
															irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
													</div>
												</div>

												<div class="single-review">
													<div class="review-heading">
														<div><a href="#"><i class="fa fa-user-o"></i> John</a></div>
														<div><a href="#"><i class="fa fa-clock-o"></i> 27 DEC 2017 / 8:0 PM</a></div>
														<div class="review-rating pull-right">
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star-o empty"></i>
														</div>
													</div>
													<div class="review-body">
														<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Duis aute
															irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
													</div>
												</div>

												<ul class="reviews-pages">
													<li class="active">1</li>
													<li><a href="#">2</a></li>
													<li><a href="#">3</a></li>
													<li><a href="#"><i class="fa fa-caret-right"></i></a></li>
												</ul>
											</div>
										</div>
										<div class="col-md-6">
											<h4 class="text-uppercase">Write Your Review</h4>
											<p>Your email address will not be published.</p>
											<form class="review-form">
												<div class="form-group">
													<input class="input" type="text" placeholder="Your Name" />
												</div>
												<div class="form-group">
													<input class="input" type="email" placeholder="Email Address" />
												</div>
												<div class="form-group">
													<textarea class="input" placeholder="Your review"></textarea>
												</div>
												<div class="form-group">
													<div class="input-rating">
														<strong class="text-uppercase">Your Rating: </strong>
														<div class="stars">
															<input type="radio" id="star5" name="rating" value="5" /><label for="star5"></label>
															<input type="radio" id="star4" name="rating" value="4" /><label for="star4"></label>
															<input type="radio" id="star3" name="rating" value="3" /><label for="star3"></label>
															<input type="radio" id="star2" name="rating" value="2" /><label for="star2"></label>
															<input type="radio" id="star1" name="rating" value="1" /><label for="star1"></label>
														</div>
													</div>
												</div>
												<button class="primary-btn">Submit</button>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div> -->

				</div>
				<!-- /Product Details -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->

	<br>
	
@endsection