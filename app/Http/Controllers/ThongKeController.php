<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tblebook;
use App\User;
use App\Hire;

class ThongKeController extends Controller
{
   public function getXem() {
   	return view('admin.thongke.xem');
   }

   //-----sửa ngày 26-7
   public function postXem(Request $req) {
      $user = User::all();
      $ngaybatdau = $req->ngaybatdau;
      $ngayketthuc= $req->ngayketthuc;
      echo $ngaybatdau;
      echo $ngayketthuc;
      return view('admin.thongke.xem');
   }

   public function getThongKe($idDanhMuc){
         if($idDanhMuc == 1){
      		$view_ebook = tblebook::orderBy('views','desc')->take(8)->get();
               echo "<thead>
                  <tr>
                    <th scope='col' class='col-1'>ID</th>
                    <th scope='col' class='col-5'>TÊN EBOOK</th>
                    <th scope='col' class='col-2'>LƯỢT XEM</th>
                    <th scope='col' class='col-2'>GIÁ</th>
                    <th scope='col' class='col-2'>GIÁ THUÊ</th>
                    
                  </tr>
                </thead>";
      		foreach ($view_ebook as $e) {
               echo "<tr>";
               echo "<td class='col-2'>".$e->id."</td>";
               echo "<td class='col-5'>".$e->name."</td>";
               echo "<td class='col-2'>".$e->views."</td>";
               echo "<td class='col-2'>".$e->price."</td>";
               echo "<td class='col-2'>".$e->hire_price."</td>";
               echo "</tr>";
            }
         }
         if($idDanhMuc == 2){
            $view_ebook = tblebook::orderBy('hire_price','desc')->take(8)->get();
               echo "<thead>
                  <tr>
                    <th scope='col' class='col-2'>ID</th>
                    <th scope='col' class='col-5'>TÊN EBOOK</th>
                    <th scope='col' class='col-2'>GIÁ THUÊ</th>
                    <th scope='col' class='col-2'>GIÁ</th>
                    <th scope='col' class='col-2'>LƯỢT XEM</th>
                    
                  </tr>
                </thead>";
            foreach ($view_ebook as $e) {
               echo "<tr>";
               echo "<td>".$e->id."</td>";
               echo "<td>".$e->name."</td>";
               echo "<td>".$e->hire_price."</td>";
               echo "<td>".$e->price."</td>";
               echo "<td>".$e->views."</td>";
               echo "</tr>";
            }
         }
         if($idDanhMuc == 3){
            echo "<div class='tm-block-col tm-col-account-settings'>
                  <div class='tm-bg-primary-dark tm-block tm-block-settings'>";
            echo "<form class='tm-signup-form row' action='' method='post'>";
            echo "<input type='hidden' name='_token' value='{{csrf_token()}}'>";
            echo "<div class='form-group col-lg-6'>
                  <label>Chọn ngày bắt đầu </label>
                  <input
                    id='ngaybatdau'
                    name='ngaybatdau'
                    type='date' max=" . date('Y-m-d'). "
                    class='form-control validate'
                  />
                </div>";
            echo "<div class='form-group col-lg-6'>
                  <label>Chọn ngày kết thúc </label>
                  <input
                    id='ngaybatdau'
                    name='ngayketthuc'
                    type='date' max=" . date('Y-m-d'). "
                    class='form-control validate'
                  />
                </div>";
            echo "<div class='form-group col-lg-6'>
                  <label class='tm-hide-sm'>&nbsp;</label>
                  <button
                    type='submit'
                    class='btn btn-primary btn-block text-uppercase'
                    >
                    thống kê
                  </button>
                </div>";
            echo "</form></div></div>";
         }
   }


   public function getTien() {
    $flag = false;
    return view('admin.thongke.tien',['flag'=>$flag]);
   }
  
    public function postTien(Request $req) {
      $flag = true;
      $user = User::all();
      $ngaybatdau = $req->ngaybatdau;
      $ngayketthuc= $req->ngayketthuc;
      $total = 0;
      if($ngaybatdau >= $ngayketthuc){
        return redirect('admin/thongke/tientheongay')->with('thongbao', 'Ngày bắt đầu phải nhỏ hơn ngày kết thúc');
      }else
      {
        $kq = Hire::whereDate('date_start','>=',$ngaybatdau)->whereDate('date_end','<=',$ngayketthuc)->get();
        foreach ($kq as $value) {
          $total += $value->total_price;
        }
        return view('admin.thongke.tien',['kqthongke'=>$kq,'total'=> $total,'flag'=>$flag]);
      }
   }

}
