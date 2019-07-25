@extends('user.layout.index')
@section('content')

<!-- section -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<div class="section-title">
						<h3 class="title">NẠP TIỀN NN-EBOOK</h3>
				</div>
				@if(session('thongbao'))
	                  <div class="alert alert-danger">
	                    {{session('thongbao')}}
	                </div>
	                @endif
				<form style="width: 500px" action="naptien/{{$user->id}}" method="post">
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<label>Tiền hiện có: {{number_format($user->money)}} xu.</label>
					<div class="billing-details">
							
							<div class="form-group">
								<input class="input" type="text" name="money" placeholder="Nhập mã code" required>
							</div>
					</div>
					<button style="float: right" type="submit" class="primary-btn add-to-cart">NẠP</button>
				</form>
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->
@endsection