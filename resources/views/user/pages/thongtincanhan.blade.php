@extends('user.layout.index')
@section('content')

<!-- section -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<form id="checkout-form" class="clearfix" action="thongtin/{{$user->id}}" method="post">
					<div class="section-title">
						<h3 class="title">Hồ sơ cá nhân của bạn</h3>
					</div>
					<div class="col-md-4">
						<div class="billing-details">
							<div class="form-group">
								<table align="center" border="1" width="250px" height="250px">
									<tr>
										<td align="center">
											<a href="#" ><img src="{{$user->image}}"></a>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>

					<div class="col-md-8">
						<div class="shiping-methods">

							@if(count($errors)>0)
								<div class="alert alert-danger">
									@foreach($errors->all() as $err)
										<h5>{{$err}}</h5>
									@endforeach
								</div>	
							@endif 
							@if(session('thongbao'))
			                  <div class="alert alert-success">
			                    {{session('thongbao')}}
			                </div>
			                @endif
						<form style="width: 500px" action="thongtin/{$user->id}" method="post">
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<div class="billing-details">
							
							<div class="form-group">
								<input class="input" type="text" name="name" value="{{$user->name}}" required>
							</div>
							<div class="form-group">
								Email: {{$user->email}}
							</div>
							
							<div class="form-group">
								<input class="input" type="text" name="phone" placeholder="Số điện thoại" value="{{$user->phone}}" required>
							</div>
							<div class="form-group">
								<div ><h4>Tiền: {{$user->money}} Xu.</h4>
								<a href="naptien">BẠN MUỐN NẠP TIỀN?</a></div>
							</div>
							<div style="float: right;"><button class="primary-btn add-to-cart" >Chỉnh sửa </button></div>
						</div>
					
				</form>
							<hr>
							
							
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