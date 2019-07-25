<header>
		<!-- header -->
		<div id="header">
			<div class="container">
				<div class="pull-left">
					<!-- Logo -->
					<div class="header-logo">
						<a class="logo" href="#">
							<img src="upload/logo.jpg" alt="">
						</a>
					</div>
					<!-- /Logo -->

					<!-- Search -->
					<div class="header-search">
						<form action="timkiem" method="post">
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<input class="input search-input" type="text" name="tukhoa" placeholder="Nhập từ khóa tìm kiếm ..." maxlength="5">
							
							<select class="input search-categories" name="danhmuctimkiem">
								<option value="0">Ebook</option>
								<option value="1">Nhà xuất bản</option>
								<option value="2">Ngôn ngữ</option>
								<option value="3">Thể loại</option>
								<option value="4">Tác giả</option>
							</select>
							<button class="search-btn"><i class="fa fa-search"></i></button>
						</form>
					</div>
					<!-- /Search -->
				</div>
				<div class="pull-right">
					<ul class="header-btns">
						<!-- Account -->
						@if(Auth::check())

						<li class="header-account dropdown default-dropdown">
							<div class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="true">
								<div class="header-btns-icon">
									<i class="fa fa-user-o"></i>
								</div>
								<strong class="text-uppercase">Chào, {{Auth::user()->name}} <i class="fa fa-caret-down"></i></strong>
							</div>
							<div class="text-uppercase" style="color:red;">xu: {{Auth::user()->money}}</div>
							<ul class="custom-menu">
								<li><a href="thongtin"><i class="fa fa-user-o"></i>trang cá nhân</a></li>
								<li><a href="thuvien"><i class="fa fa-heart-o"></i>thư viện</a></li>
								<li><a href="doipass"><i class="fa fa-check"></i>Đổi mật khẩu</a></li>
								<li><a href="dangxuat"><i class="fa fa-unlock-alt"></i>đăng xuất</a></li>
							</ul>
						</li>
						@else 
						<li class="header-account dropdown default-dropdown">
							<div class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="true">
								<div class="header-btns-icon">
									<i class="fa fa-user-o"></i>
								</div>
								<strong class="text-uppercase">tài khoản <i class="fa fa-caret-down"></i></strong>
							</div>
							<a href="#" class="text-uppercase">--</a>
							<ul class="custom-menu">
								
								<li><a href="dangnhap"><i class="fa fa-unlock-alt"></i> đăng nhập</a></li>
								<li><a href="dangky"><i class="fa fa-user-plus"></i>tạo tài khoản mới</a></li>
							</ul>
						</li>
						@endif
						<!-- /Account -->

						<!-- Cart --><!--
						<li class="header-cart dropdown default-dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
								<div class="header-btns-icon">
									<i class="fa fa-shopping-cart"></i>
									<span class="qty">3</span>
								</div>
								<strong class="text-uppercase">My Cart:</strong>
								<br>
								<span>35.20$</span>
							</a>
							<div class="custom-menu">
								<div id="shopping-cart">
									<div class="shopping-cart-list">
										<div class="product product-widget">
											<div class="product-thumb">
												<img src="./img/thumb-product01.jpg" alt="">
											</div>
											<div class="product-body">
												<h3 class="product-price">$32.50 <span class="qty">x3</span></h3>
												<h2 class="product-name"><a href="#">Product Name Goes Here</a></h2>
											</div>
											<button class="cancel-btn"><i class="fa fa-trash"></i></button>
										</div>
										<div class="product product-widget">
											<div class="product-thumb">
												<img src="./img/thumb-product01.jpg" alt="">
											</div>
											<div class="product-body">
												<h3 class="product-price">$32.50 <span class="qty">x3</span></h3>
												<h2 class="product-name"><a href="#">Product Name Goes Here</a></h2>
											</div>
											<button class="cancel-btn"><i class="fa fa-trash"></i></button>
										</div>
									</div>
									<div class="shopping-cart-btns">
										<button class="main-btn">View Cart</button>
										<button class="primary-btn">Checkout <i class="fa fa-arrow-circle-right"></i></button>
									</div>
								</div>
							</div>
						</li> -->
						<!-- /Cart --> 
						<!-- Mobile nav toggle-->
						<li class="nav-toggle">
							<button class="nav-toggle-btn main-btn icon-btn"><i class="fa fa-bars"></i></button>
						</li>
						<!-- / Mobile nav toggle -->
					</ul>
				</div>
			</div>
			<!-- header -->
		</div>
		<!-- container -->
</header>

<!-- thanh menu-->
	<div id="navigation">
		<!-- container -->
		<div class="container">
			<div id="responsive-nav">
				<!-- category nav -->
				<div class="category-nav show-on-click">
					<span class="category-header">DANH MỤC <i class="fa fa-list"></i></span>
					<ul class="category-list">
						<li class="dropdown side-dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">NHÀ XUẤT BẢN <i class="fa fa-angle-right"></i></a>
							<div class="custom-menu">
								<div class="row">
									<div class="col-md-12">
										<ul class="list-links">
											<hr>
											@foreach($nhaxuatban as $nxb)
											<li><a href="loaiebook/1/{{$nxb->id}}">{{$nxb->name}}</a></li>
											@endforeach
										</ul>
										<hr>
									</div>
								</div>
								
							</div>
						</li>
						<li class="dropdown side-dropdown"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">THỂ LOẠI <i class="fa fa-angle-right"></i></a>
							<div class="custom-menu">
								<div class="row">
									<div class="col-md-12">
										<ul class="list-links">
											<hr>
											@foreach($theloai as $type)
											<li><a href="loaiebook/2/{{$type->id}}">{{$type->name}}</a></li>
											@endforeach
										</ul>
										<hr>
									</div>
									
								</div>
							</div>
						</li>
						<li class="dropdown side-dropdown"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">NGÔN NGỮ <i class="fa fa-angle-right"></i></a>
							<div class="custom-menu">
								<div class="row">
									<div class="col-md-12">
										<ul class="list-links">
											<hr>
											@foreach($ngonngu as $lan)
											<li><a href="loaiebook/3/{{$lan->id}}">{{$lan->name}}</a></li>
											@endforeach
										</ul>
										<hr>
									</div>
								</div>
							</div>
						</li>
						<li class="dropdown side-dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">TÁC GIẢ <i class="fa fa-angle-right"></i></a>
							<div class="custom-menu">
								<div class="row">
									<div class="col-md-12">
										<ul class="list-links">
											<hr>
											@foreach($tacgia as $au)
											<li><a href="loaiebook/4/{{$au->id}}">{{$au->name}}</a></li>
											@endforeach
										</ul>
										<hr>
									</div>
								</div>
							</div>
						</li>
						
					</ul>
				</div>
				<!-- /category nav -->

				<!-- menu nav -->
				<div class="menu-nav">
					<span class="menu-header">Menu <i class="fa fa-bars"></i></span>
					<ul class="menu-list">
						<li><a href="trangchu">TRANG CHỦ</a></li>
						<li><a href="ebook">ebook</a></li>
						<li><a href="chinhsach">chính sách</a></li>
							
						<li><a href="vechungtoi">về chúng tôi</a></li>
						<li><a href="lienhe">liên hệ</a></li>

					</ul>
				</div>
				<!-- menu nav -->
			</div>
		</div>
		<!-- /container -->
	</div>