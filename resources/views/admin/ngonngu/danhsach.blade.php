@extends('admin.layout.index')
@section('content')
<div class="container mt-5">
      <div class="row tm-content-row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 tm-block-col">
          <div class="tm-bg-primary-dark tm-block tm-block-products">
            <div class="tm-product-table-container">
              @if(session('thongbao'))
                  <div class="alert alert-success">{{session('thongbao')}}</div>
                @endif
              <table class="table table-hover tm-table-small tm-product-table">
                <thead>
                  <tr>
                    <th scope="col">&nbsp;</th>
                    <th scope="col">ID</th>
                    <th scope="col">TÊN NGÔN NGỮ</th>
                    <th scope="col">&nbsp;</th>
                    <th scope="col">&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($language as $lan)
                  <tr>
                    <th scope="row"><input type="checkbox" /></th>
                    <td class="tm-product-name">{{$lan->id}}</td>
                    <td class="tm-product-name">{{$lan->name}}</td>
                    
                    <td>
                      <a href="admin/ngonngu/sua/{{$lan->id}}" class="tm-product-delete-link">
                       <img src="backend/img/Edit.png">
                      </a>
                      <a href="admin/ngonngu/xoa/{{$lan->id}}" class="tm-product-delete-link">
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
              href="admin/ngonngu/them"
              class="btn btn-primary btn-block text-uppercase mb-3">Thêm mới</a>
            
          </div>
        </div>
      </div>
    </div>
@endsection