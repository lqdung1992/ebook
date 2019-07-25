<div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto h-100">
                        <li class="nav-item">
                            <a class="nav-link" href="admin/dashboard">
                                <i class="fas fa-tachometer-alt"></i>
                                Tổng quát
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">

                            <a class="nav-link" href="admin/thongke/xem">
                                <i class="far fa-file-alt"></i>
                                <span>
                                    Thống kê </i>
                                </span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="admin/ebook/danhsach">
                                <i class="fas fa-shopping-cart"></i>
                                Ebook
                            </a>
                        </li>
                        <li class="nav-item dropdown">

                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="far fa-file-alt"></i>
                                <span>
                                    Cập nhật <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="admin/nhaxuatban/danhsach">Nhà xuất bản</a>
                                <a class="dropdown-item" href="admin/theloai/danhsach">Thể loại</a>
                                <a class="dropdown-item" href="admin/ngonngu/danhsach">Ngôn ngữ</a>
                                <a class="dropdown-item" href="admin/tacgia/danhsach">Tác giả</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin/user/danhsach">
                                <i class="far fa-user"></i>
                                User
                            </a>
                        </li>
                        
                       <!--  <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cog"></i>
                                <span>
                                    Cài đặt <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Profile</a>
                                <a class="dropdown-item" href="#">Billing</a>
                                <a class="dropdown-item" href="#">Customize</a>
                            </div>
                        </li> -->
                    </ul>
                    @if(Auth::check())
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link d-block" href="logout">
                                {{Auth::user()->name}}, <b>Đăng xuất</b>
                            </a>
                        </li>
                    </ul>
                    @endif
                </div>