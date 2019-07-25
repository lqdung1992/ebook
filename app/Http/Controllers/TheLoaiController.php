<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbltype;
class TheLoaiController extends Controller
{
   public function getDanhSach() {
   	$type = tbltype::all();
   	return view('admin.theloai.danhsach',['type'=>$type]);
   }

   public function getSua($id) {
      $type = tbltype::find($id);
      return view('admin.theloai.sua', ['type'=>$type]);
   }
   public function postSua(Request $req, $id) {
         $type = tbltype::find($id);
         $this->validate($req, 
            [
               'name' => 'required|unique:type,name|min:3|max:200'
            ],
            [
               'name.required' => 'Bạn chưa nhập tên thể loại', 
               'name.unique' => 'ten thể loại đã tồn tại',
               'name.min' => 'Tên thể loại tối thiểu 3 ký tự.', 
               'name.max' => 'Tên thể loại tối đa 200 ký tự.'
            ]);
         $type->name = $req->name;
         $type->save();

         return redirect('admin/theloai/sua/'.$id)->with('thongbao','Bạn đã sửa thành công');
   }


   public function getThem() {
   	return view('admin.theloai.them');
   }
   
   public function postThem(Request $req) {
         $this->validate($req, 
            [
               'name' => 'required|unique:tbltype,name|min:3|max:200'
            ],
            [
               'name.required' => 'Bạn chưa nhập tên ebook', 
               'name.unique' => 'ten thể loại đã tồn tại',
               'name.min' => 'Tên ebook tối thiểu 3 ký tự.', 
               'name.max' => 'Tên ebook tối đa 200 ký tự.'
            ]);
         $type = new tbltype();
         $type->name = $req->name;
         //$new_str = utf8tourl(utf8convert($req->name));
         //echo $new_str;
         $type->save();

         return redirect('admin/theloai/them')->with('thongbao','Bạn đã thêm thành công');
   }

   public function getXoa($id){
      $type = tbltype::find($id);
      if(count($type->type_ebook)> 0)
      {
         return redirect('admin/theloai/danhsach')->with('thongbao','Thể loại này có ebook.');
      }else{
         $type->delete();
         return redirect('admin/theloai/danhsach')->with('thongbao','Bạn đã xóa thành công');
      }
   }
}
