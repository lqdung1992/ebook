<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tblpublisher;

class NhaXuatBanController extends Controller
{
   public function getDanhSach() {
   	$pub = tblpublisher::all();
   	return view('admin.nhaxuatban.danhsach',['publisher'=>$pub]);
   }

   public function getSua($id) {
      $pub = tblpublisher::find($id);
      return view('admin.nhaxuatban.sua', ['publisher'=>$pub]);
   }
   public function postSua(Request $req, $id) {
         $pub = tblpublisher::find($id);
         $this->validate($req, 
            [
               'name' => 'required|unique:publisher,name|min:3|max:200'
            ],
            [
               'name.required' => 'Bạn chưa nhập tên thể loại', 
               'name.unique' => 'Tên thể loại đã tồn tại',
               'name.min' => 'Tên thể loại tối thiểu 3 ký tự.', 
               'name.max' => 'Tên thể loại tối đa 200 ký tự.'
            ]);
         $pub->name = $req->name;
         $pub->save();

         return redirect('admin/nhaxuatban/sua/'.$id)->with('thongbao','Bạn đã sửa thành công');
   }


   public function getThem() {
   	return view('admin.nhaxuatban.them');
   }
   
   public function postThem(Request $req) {
         $this->validate($req, 
            [
               'name' => 'required|unique:publisher,name|min:3|max:200'
            ],
            [
               'name.required' => 'Bạn chưa nhập tên ebook', 
               'name.unique' => 'ten thể loại đã tồn tại',
               'name.min' => 'Tên ebook tối thiểu 3 ký tự.', 
               'name.max' => 'Tên ebook tối đa 200 ký tự.'
            ]);
         $pub = new tblpublisher();
         $pub->name = $req->name;
         //$new_str = utf8tourl(utf8convert($req->name));
         //echo $new_str;
         $pub->save();

         return redirect('admin/nhaxuatban/them')->with('thongbao','Bạn đã thêm thành công');
   }

   public function getXoa($id){
      $pub = tblpublisher::find($id);
      if(count($pub->ebook)> 0)
      {
         return redirect('admin/nhaxuatban/danhsach')->with('thongbao','Nhà xuất bản này có ebook.');
      }else{
         $pub->delete();
         return redirect('admin/nhaxuatban/danhsach')->with('thongbao','Bạn đã xóa thành công');
      }
   }
  
}
