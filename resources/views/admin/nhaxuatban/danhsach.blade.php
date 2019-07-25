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
                    <th scope="col">TÊN NHÀ XUẤT BẢN</th>
                    <th scope="col">&nbsp;</th>
                    <th scope="col">&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($publisher as $nxb)
                  <tr>
                    <th scope="row"><input type="checkbox" /></th>
                    <td class="tm-product-name">{{$nxb->id}}</td>
                    <td class="tm-product-name">{{$nxb->name}}</td>
                    
                    <td>
                      <a href="admin/nhaxuatban/sua/{{$nxb->id}}" class="tm-product-delete-link">
                       <img src="backend/img/Edit.png">
                      </a>
                      <a href="admin/nhaxuatban/xoa/{{$nxb->id}}" class="tm-product-delete-link">
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
              href="admin/nhaxuatban/them"
              class="btn btn-primary btn-block text-uppercase mb-3">Thêm mới thể loại</a>
            
          </div>
        </div>
      </div>
    </div>
@endsection