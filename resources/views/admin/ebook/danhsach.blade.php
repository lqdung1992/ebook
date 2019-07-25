@extends('admin.layout.index')
@section('content')
<div class="container mt-5">
      <div class="row tm-content-row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 tm-block-col">
          <div class="tm-bg-primary-dark tm-block tm-block-products">
            <div class="tm-product-table-container">
              @if(count($errors)>0)
                  <div class='alert alert-danger'>
                    @foreach($errors->all() as $err)
                      {{$err}}<br>
                    @endforeach
                  </div>
                @endif

                @if(session('thongbao'))
                  <div class="alert alert-success">{{session('thongbao')}}</div>
                @endif
              <table class="table table-hover tm-table-small tm-product-table">
                <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">TÊN EBOOK</th>
                    <th scope="col">MÔ TẢ</th>
                    <th scope="col">LINK NỘI DUNG</th>
                    <th scope="col">SỐ TRANG</th>
                    <th scope="col">ẢNH</th>
                    <th scope="col">GIÁ THUÊ</th>
                    <th scope="col">GIÁ EBOOK</th>
                    <th scope="col">NXB</th>
                    <th scope="col">&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($ebook as $e)
                  <tr>
                    <td>{{$e->id}}</td>
                    <td class="tm-product-name">{{$e->name}}</td>
                    <td>{{$e->description}}</td>
                    <td>{{$e->link_content}}</td>
                    <td>{{$e->pagenum}}</td>
                    <td>{{$e->image}}</td>
                    <td>{{$e->hire_price}}</td>
                    <td>{{$e->price}}</td>
                    <td>{{$e->publisher->name}}</td>
                    <td>
                      <a href="admin/ebook/sua/{{$e->id}}" class="tm-product-delete-link">
                       <img src="backend/img/Edit.png">
                      </a>
                      <a href="admin/ebook/xoa/{{$e->id}}" class="tm-product-delete-link">
                        <i class="far fa-trash-alt tm-product-delete-icon"></i>
                      </a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- table container -->
            <a
              href="admin/ebook/them"
              class="btn btn-primary btn-block text-uppercase mb-3">Thêm mới ebook </a>
          </div>
        </div>
      </div>
    </div>
@endsection