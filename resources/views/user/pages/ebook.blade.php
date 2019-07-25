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
							<h3 class="product-price">{{number_format($e->hire_price)}} Xu</h3>
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
			<!-- /row -->
			<div class="row" style="text-align: right;">{{$ebook->links()}}</div>
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

@endsection