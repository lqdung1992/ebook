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
					<form id="checkout-form" class="clearfix" style="width: 500px" action="dangky" method="post">
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<div class="billing-details">
							<div class="section-title">
								<h3 class="title">ĐĂNG KÝ THÀNH VIÊN</h3>
							</div>
							<p>Bạn đã có tài khoản? <a href="dangnhap"> Đăng nhập.</a></p>
							<!--@if(count($errors)>0) -->
								<div class="alert alert-danger">
									@foreach($errors->all() as $err)
										<h5>{{$err}}</h5>
									@endforeach
								</div>	
							<!--@endif -->
							<div class="form-group">
								<input class="input" type="email" name="email" value="{{old('email')}}" placeholder="Email đăng nhập" required>
							</div>
							
							<div class="form-group">
								<input class="input" type="password" name="password" placeholder="Mật khẩu"  required>
							</div>
							<div class="form-group">
								<input class="input" type="password" name="re_password" placeholder="Nhập lại mật khẩu"  required>
							</div>
							<div class="form-group">
								<input class="input" type="text" name="name" value="{{old('name')}}" placeholder="Họ và tên" required>
							</div>
							
							<div class="form-group">
								<input class="input" type="text" value="{{old('phone')}}" name="phone" placeholder="Số điện thoại" required>
							</div>
							<div class="pull-right">
								<button class="primary-btn" name="dangky" type="submit" value="sm">ĐĂNG KÝ</button>
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

@endsection