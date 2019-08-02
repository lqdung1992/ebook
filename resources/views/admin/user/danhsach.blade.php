@extends('admin.layout.index')
@section('content')
<div class="container mt-5">
      <div class="row tm-content-row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 tm-block-col">
          <div class="tm-bg-primary-dark tm-block tm-block-products">
            <div class="tm-product-table-container">
              <table class="table table-hover tm-table-small tm-product-table">
                <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">NAME</th>
                    <th scope="col">MAIL</th>
                    <th scope="col">PHONE</th>
                    <th scope="col">MONEY</th>
                    <th scope="col">UPDATED_AT</th>
                    <th scope="col">CREATE_AT</th>
                    <th scope="col">&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($user as $e)
                  <tr>
                    <td>{{$e->id}}</td>
                    <td class="tm-product-name">{{$e->name}}</td>
                    <td>{{$e->email}}</td>
                    <td>{{$e->phone}}</td>
                    <td>{{$e->money}}</td>
                    <td>{{$e->updated_at}}</td>
                    <td>{{$e->created_at}}</td>
                    @if($e->role == 0)
                    <td>
                      <a href="admin/user/profile/{{$e->id}}" class="tm-product-delete-link">
                       <img src="backend/img/xem.png">
                      </a>
                    </td>
                    @else 
                      <td>
                      <a href="admin/user/xem/{{$e->id}}" class="tm-product-delete-link">
                       <img src="backend/img/xem.png">
                      </a>
                    </td>
                    @endif
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- table container -->
            
          </div>
        </div>
      </div>
    </div>
@endsection