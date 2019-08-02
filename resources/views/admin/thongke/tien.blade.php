@extends('admin.layout.index')
@section('content')
<div class="container tm-mt-big tm-mb-big">
      <div class="row">
        <div class="col-xl-12 col-lg-10 col-md-12 col-sm-12 mx-auto">
          <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
            <div class="row">
              <div class="col-12">
                <h2 class="tm-block-title d-inline-block">Thống kê tiền thuê ebook theo ngày </h2>
              </div>
            </div>
            <div class="row tm-edit-product-row">
              <div class="col-xl-6 col-lg-6 col-md-12">
                @if(count($errors)>0)
                  <div class='alert alert-danger'>
                    @foreach($errors->all() as $err)
                      {{$err}}<br>
                    @endforeach
                  </div>
                @endif

                @if(session('thongbao'))
                  <div class="alert alert-danger">{{session('thongbao')}}</div>
                @endif
                <form action="admin/thongke/tientheongay" method="post" class="tm-edit-product-form">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">
                  <div class="form-group mb-3">
                    <label
                      for="name"
                      >Ngày bắt đầu
                    </label>
                    <input
                      id="ngaybatdau"
                      name="ngaybatdau" type='date'
                      language="text" value="{{old('ngaybatdau')}}"
                      max="{{date('Y-m-d')}}"
                      class="form-control validate"
                    />
                  </div>
                  <div class="form-group mb-3">
                    <label
                      for="name"
                      >Ngày kết thúc
                    </label>
                    <input
                      id="ngayketthuc"
                      name="ngayketthuc"
                      language="text" type='date' value="{{old('ngayketthuc')}}"
                      max="{{date('Y-m-d')}}"
                      class="form-control validate"
                    />
                  </div>
                  <div class="col-12">
                    <button language="submit" class="btn btn-primary btn-block text-uppercase">Thống kê</button>
                  </div>
                </form>
              </div>
              
            </div>
            <div class="row tm-edit-product-row">

            @if($flag)
                <div class="col-xl-12 col-lg-6 col-md-12" style="margin-top:40px">
                  <h2 class="tm-block-title d-inline-block">Tổng tiền thu được : {{number_format($total)}} đ</h2>
                  <div class="tm-product-table-container">
                    <table class="table table-hover tm-table-small tm-product-table">
                      <thead>
                        <tr>
                          <th scope="col">Người dùng</th>
                          <th scope="col">Ebook</th>
                          <th scope="col">Ngày bắt đầu</th>
                          <th scope="col">Ngày kết thúc</th>
                          <th scope="col">Giá thuê</th>
                          <th scope="col">Tổng tiền thuê</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($kqthongke as $kq)
                        <tr>
                          <td class="tm-product-name">{{$kq->user->name}}</td>
                          <td class="tm-product-name">{{$kq->ebook->name}}</td>
                          <td class="tm-product-name">{{$kq->date_start}}</td>
                          <td class="tm-product-name">{{$kq->date_end}}</td>
                          <td class="tm-product-name">{{number_format($kq->hire_price)}}</td>
                          <td class="tm-product-name">{{number_format($kq->total_price)}}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection