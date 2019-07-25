
@extends('admin.layout.index')
@section('content')
<div class="container tm-mt-big tm-mb-big">
      <div class="row">
        <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 mx-auto">
          <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
            <div class="row">
              <div class="col-12">
                <h2 class="tm-block-title d-inline-block">Sửa thể loại</h2> {{$type->name}}
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
                  <div class="alert alert-success">{{session('thongbao')}}</div>
                @endif
                <form action="admin/theloai/sua/{{$type->id}}" method="post" class="tm-edit-product-form">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">
                  <div class="form-group mb-3">
                    <label
                      for="name"
                      >Tên thể loại
                    </label>
                    <input
                      id="name"
                      name="name"
                      type="text"
                      value="{{$type->name}}"
                      class="form-control validate"
                    />
                  </div>
                  
              </div>
              
              <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block text-uppercase">Sửa</button>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endsection