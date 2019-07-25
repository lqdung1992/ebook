@extends('admin.layout.index')
@section('content')
<div class="container tm-mt-big tm-mb-big">
      <div class="row">
        <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 mx-auto">
          <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
            <div class="row">
              <div class="col-12">
                <h2 class="tm-block-title d-inline-block">SỬA EBOOK: {{$ebook->name}}</h2>
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
                <form action="admin/ebook/sua/{{$ebook->id}}" class="tm-edit-product-form" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">
                  <div class="form-group mb-3">
                    <label
                      for="name"
                      >Tên ebook
                    </label>
                    <input
                      id="name"
                      name="name"
                      type="text"
                      value="{{$ebook->name}}"
                      class="form-control validate"
                      required
                    />
                  </div>
                  <div class="form-group mb-3">
                    <label
                      for="description"
                      >Mô tả</label
                    >
                    <textarea
                      class="form-control validate"
                      rows="3"
                      name="description"
                      
                      required
                    >{{$ebook->description}}</textarea>
                  </div>
                  <div class="form-group mb-3">
                    <label
                      for="name"
                      >Số trang
                    </label>
                    <input
                      id="pagenum"
                      name="pagenum"
                      type="number" min="5" max="1000"
                      value="{{$ebook->pagenum}}"
                      class="form-control validate"
                      required
                    />
                  </div>
                    
                  <div class="row">
                      <div class="form-group mb-3 col-xs-12 col-sm-6">
                          <label
                            for="expire_date"
                            >Giá gốc ebook
                          </label>
                          <input
                            id="price"
                            name="price"
                            type="number" min="10000" max="100000"
                            value="{{$ebook->price}}"
                            class="form-control validate"
                            data-large-mode="true"
                          />
                        </div>
                        <div class="form-group mb-3 col-xs-12 col-sm-6">
                          <label
                            for="stock"
                            >Giá thuê 1 ngày
                          </label>
                          <input
                            id="hire_price"
                            name="hire_price"
                            type="number" min="1000" max="10000"
                            value="{{$ebook->hire_price}}"
                            class="form-control validate"
                            required
                          />
                        </div>
                  </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-12 mx-auto mb-4">
                <!-- <div class="form-group mb-3">
                    <label
                      for="image"
                      >Ảnh bìa
                    </label><br>
                    <input
                      id="image"
                      name="image"
                      type="file"
                      required
                    />
                  </div> -->
                  <!-- <div class="form-group mb-3">
                    <label
                      for="image"
                      >Nội dung
                    </label><br>
                    <input
                      id="link_content"
                      name="link_content"
                      type="file"
                      required
                    />
                  </div> -->
                  <!-- <div class="form-group mb-3">
                    <label
                      for="category"
                      >Ngôn ngữ</label
                    >
                    <select
                      class="custom-select tm-select-accounts"
                      id="language"
                      name="language"
                    >
                      @foreach($ebook->language_ebook as $e)
                      <option value="">{{$e->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <label
                      for="category"
                      >Thể loại</label
                    >
                    <select
                      class="custom-select tm-select-accounts"
                      id="type"
                      name="type"
                    >
                      <option value="{{$ebook->publisher->id}}">{{$ebook->publisher->name}}</option>
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <label
                      for="category"
                      >Nhà xuất bản</label
                    >
                    <select
                      class="custom-select tm-select-accounts"
                      id="publisher"
                      name="publisher"
                    >
                      <option value=""></option>
                    </select>
                  </div>
                  <div class="form-group mb-3">
                      <label
                        for="category"
                        >Tác giả</label
                      >
                      <select
                        class="custom-select tm-select-accounts"
                        id="author"
                        name="author"
                      >
                        <option value=""></option>
                      </select>
                  </div>   -->
              </div>

              <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block text-uppercase">Sửa Ebook</button>
              </div>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
