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

				<div class="col-md-12" align="center">
					@if(count($errors)>0)
	                  <div class="alert alert-danger">
	                    @foreach($errors->all() as $err)
	                      <h5>{{$err}}</h5>
	                    @endforeach
	                  </div>
	                @endif
	                @if(session('thongbao'))
	                  <div class="alert alert-danger">
	                    {{session('thongbao')}}
	                </div>
	                @endif
					<form id="checkout-form" class="clearfix" style="width: 500px" action="dangnhap" method="post" >
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<div class="billing-details">
							<div class="section-title">
								<h3 class="title">ĐĂNG NHẬP</h3>
							</div>	

							<div class="form-group">
								<input class="input" type="email" name="email" placeholder="Email đăng nhập" required>
							</div>
							<div class="form-group">
								<input class="input" type="password" name="password" placeholder="Mật khẩu" required>
							</div>
							
							<div><input type="checkbox" name="remember" value="remember"> Ghi nhớ đăng nhập.
								<!-- <div class="form-group" >
									<a href="laylaimatkhau">Quên mật khẩu?</a>
								</div> -->
							</div>
							<div class="form-group" style="float: left;">
								Bạn chưa có tài khoản? <a href="dangky">Đăng ký.</a>
							</div><br>
							
							<div class="pull-right">
								<button class="primary-btn" name="dangnhap" type="submit" value="dn">ĐĂNG NHẬP</button>
							</div>
						</div>
					
				</form>
			</div>
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->
	<div style="height: 70px"></div>
@endsection