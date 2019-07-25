
@extends('admin.layout.index')
@section('content')
<div class="container tm-mt-big tm-mb-big">
      <div class="row">
        <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 mx-auto">
          <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
            <div class="row">
              <div class="col-12">
                <h2 class="tm-block-title d-inline-block">THÔNG TIN THUÊ CỦA USER: {{$user->name}}</h2>
              </div>
            </div>
            <div class="row tm-edit-product-row">
              <div class="col-xl-12 col-lg-12 col-md-12">
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
                <form  method="post" class="tm-edit-product-form">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">
                  <div class="form-group mb-3">
                    <label
                      for="name"
                      >Tên
                    </label>
                    <input
                      id="name"
                      name="name"
                      type="text"
                      value="{{$user->name}}"
                      class="form-control validate"
                    />
                  </div>
                  <div class="form-group mb-3">
                    <label
                      for="email"
                      >Email
                    </label>
                    <input
                      id="email"
                      name="email"
                      type="text"
                      value="{{$user->email}}"
                      class="form-control validate"
                    />
                  </div>
                  <div style="color: orange" ><h4>Tiền còn lại: {{$user->money}}</h4></div>
                  <div class="form-group mb-3">
                    <label
                      for="name"
                      >Thông tin ebook
                    </label>
                    <div>
                      <table class="table table-hover tm-table-small tm-product-table">
                        <thead>
                          <tr>
                            <th scope="col">TÊN EBOOK</th>
                            <th scope="col">NGÀY BẮT ĐẦU</th>
                            <th scope="col">GIỜ BẮT ĐẦU</th>
                            <th scope="col">NGÀY KẾT THÚC</th>
                            <th scope="col">GIỜ KẾT THÚC</th>
                            <th scope="col">GIÁ THUÊ</th>
                            <th scope="col">TỔNG TIỀN</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($user->hire as $v)
                          <tr>
                            <td class="tm-product-name">{{$v->name}}</td>
                            <td class="tm-product-name">{{$v->pivot->date_start}}</td>
                            <td class="tm-product-name">{{$v->pivot->hour_start}}</td>
                            <td class="tm-product-name">{{$v->pivot->date_end}}</td>
                            <td class="tm-product-name">{{$v->pivot->hour_end}}</td>
                            <td class="tm-product-name">{{$v->hire_price}}</td>
                            <td class="tm-product-name">{{$v->pivot->total_price}}</td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
              <div class="col-12">
                <a href="admin/user/danhsach">Quay lại</a>
              </div>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endsection