<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbllanguage;

class NgonNguController extends Controller
{
   public function getDanhSach() {
   	$lan = tbllanguage::all();
   	return view('admin.ngonngu.danhsach',['language'=>$lan]);
   }

   public function getSua($id) {
      $lan = tbllanguage::find($id);
      return view('admin.ngonngu.sua', ['language'=>$lan]);
   }
   public function postSua(Request $req, $id) {
         $lan = tbllanguage::find($id);
         $this->validate($req, 
            [
               'name' => 'required|unique:language,name|min:3|max:200'
            ],
            [
               'name.required' => 'Bạn chưa nhập tên thể loại', 
               'name.unique' => 'ten thể loại đã tồn tại',
               'name.min' => 'Tên thể loại tối thiểu 3 ký tự.', 
               'name.max' => 'Tên thể loại tối đa 200 ký tự.'
            ]);
         $lan->name = $req->name;
         $lan->save();

         return redirect('admin/ngonngu/sua/'.$id)->with('thongbao','Bạn đã sửa thành công');
   }


   public function getThem() {
   	return view('admin.ngonngu.them');
   }
   
   public function postThem(Request $req) {
         $this->validate($req, 
            [
               'name' => 'required|unique:language,name|min:3|max:200'
            ],
            [
               'name.required' => 'Bạn chưa nhập tên ebook', 
               'name.unique' => 'Tên thể loại đã tồn tại',
               'name.min' => 'Tên ebook tối thiểu 3 ký tự.', 
               'name.max' => 'Tên ebook tối đa 200 ký tự.'
            ]);
         $lan = new tbllanguage();
         $lan->name = $req->name;
         //$new_str = utf8toulr(utf8convert($req->name));
         //echo $new_str;
         
         
         $lan->save();
         return redirect('admin/ngonngu/them')->with('thongbao','Bạn đã thêm thành công');
   }

   public function getXoa($id){
      $lan = tbllanguage::find($id);
      if(count($lan->language_ebook)> 0)
      {
         return redirect('admin/ngonngu/danhsach')->with('thongbao','Ngôn ngữ này có ebook.');
      }else{
         $lan->delete();
         return redirect('admin/ngonngu/danhsach')->with('thongbao','Bạn đã xóa thành công');
      }
   }
  
}
