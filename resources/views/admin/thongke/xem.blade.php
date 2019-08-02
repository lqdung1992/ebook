@extends('admin.layout.index')
@section('content')
<div class="container mt-5">
        <div class="row tm-content-row">
          <div class="col-8 tm-block-col">
            <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
              <h2 class="tm-block-title">Danh mục thống kê</h2>
              <select class="custom-select" name="danhmuc" id="danhmuc">
                <option >---Chọn danh mục---</option>
                <option value="1">Ebook theo lượt thuê</option>
                <option value="2">Ebook theo giá thuê</option>
              </select>
            </div>
        </div>
        <div class="col-12 tm-block-col">
            <div class="tm-bg-primary-dark tm-block tm-block-products">
            <div class="tm-product-table-container">
              <table class="table table-hover tm-table-small tm-product-table">
                <!-- <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">TÊN EBOOK</th>
                    <th scope="col">GIÁ</th>
                    <th scope="col">GIÁ THUÊ</th>
                    <th scope="col">LƯỢT XEM</th>
                  </tr>
                </thead> -->
                <tbody id="ebook">
                </tbody>
              </table>
            </div>
            <!-- table container -->
            
          </div>
          </div>
        </div> 
        <!-- row -->
        


      </div>


@endsection

@section('script')
  <script type="text/javascript">
    $(document).ready(function(){
      $("#danhmuc").change(function(){
        var idDanhMuc = $(this).val();
        $.get("admin/thongke/xem/"+idDanhMuc,function(data){
          $("#ebook").html(data);
        });
      })
    });
  </script>
@endsection