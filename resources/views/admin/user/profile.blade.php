@extends('admin.layout.index')
@section('content')
<div class="container mt-5">
        
        <div class="row tm-content-row">
          <div class="tm-block-col tm-col-avatar">
            <div class="tm-bg-primary-dark tm-block tm-block-avatar">
              <h2 class="tm-block-title"> Ảnh đại diện</h2>
              <div class="tm-avatar-container">
                <img
                  src="backend/img/avatar.png"
                  alt="Avatar"
                  class="tm-avatar img-fluid mb-4"
                />
                <a href="#" class="tm-avatar-delete-link">
                  <i class="far fa-trash-alt tm-product-delete-icon"></i>
                </a>
              </div>
              <button class="btn btn-primary btn-block text-uppercase">
                Tải ảnh khác
              </button>
            </div>
          </div>
          <div class="tm-block-col tm-col-account-settings">
            <div class="tm-bg-primary-dark tm-block tm-block-settings">
              <h2 class="tm-block-title">Thông tin Admin: {{$admin->name}}</h2>
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
              <form action="admin/user/profile/{{$admin->id}}" class="tm-signup-form row" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="form-group col-lg-6">
                  <label for="name">Tên </label>
                  <input
                    id="name"
                    name="name"
                    value="{{$admin->name}}"
                    type="text"
                    class="form-control validate"
                  />
                </div>
                <div class="form-group col-lg-6">
                  <label for="email">Email</label>
                  <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{$admin->email}}"
                    class="form-control validate"
                  />
                </div>
                
                <div class="form-group col-lg-6">
                  <label class="tm-hide-sm">&nbsp;</label>
                  <button
                    type="submit"
                    class="btn btn-primary btn-block text-uppercase"
                    >
                    Sửa
                  </button>
                </div>
                
              </form>
            </div>
          </div>
        </div>
      </div>
@endsection