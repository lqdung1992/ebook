<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tblebook;

class ThongKeController extends Controller
{
   public function getXem() {
   	return view('admin.thongke.xem');
   }

   public function getThongKe($idDanhMuc){
         if($idDanhMuc == 1){
      		$view_ebook = tblebook::orderBy('views','desc')->take(8)->get();
               
      		foreach ($view_ebook as $e) {
               echo "<tr>";
               echo "<td>".$e->id."</td>";
               echo "<td>".$e->name."</td>";
               echo "<td>".$e->price."</td>";
               echo "<td>".$e->hire_price."</td>";
               echo "<td>".$e->views."</td>";
               echo "</tr>";
            }
         }
         // if($idDanhMuc == 2){
         //    $view_user = ::orderBy('views','desc')->take(8)->get();
         //    foreach ($view_ebook as $e) {
         //       echo "<tr>";
         //       echo "<td>".$e->id."</td>";
         //       echo "<td>".$e->name."</td>";
         //       echo "<td>".$e->price."</td>";
         //       echo "<td>".$e->hire_price."</td>";
         //       echo "<td>".$e->views."</td>";
         //       echo "</tr>";
         //    }
         // }
   }
  
}
