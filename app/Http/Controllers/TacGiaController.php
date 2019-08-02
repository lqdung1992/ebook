<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tblauthor;

class TacGiaController extends Controller
{
   public function getDanhSach() {
   	$au = tblauthor::all();
   	return view('admin.tacgia.danhsach',['author'=>$au]);
   }

   public function getSua($id) {
      $au = tblauthor::find($id);
      return view('admin.tacgia.sua', ['author'=>$au]);
   }
   public function postSua(Request $req, $id) {
         $au = tblauthor::find($id);
         $this->validate($req, 
            [
               'name' => 'required|unique:author,name|min:3|max:200'
            ],
            [
               'name.required' => 'Bạn chưa nhập tên thể loại', 
               'name.unique' => 'ten thể loại đã tồn tại',
               'name.min' => 'Tên thể loại tối thiểu 3 ký tự.', 
               'name.max' => 'Tên thể loại tối đa 200 ký tự.'
            ]);
         $au->name = $req->name;
         $au->save();

         return redirect('admin/tacgia/sua/'.$id)->with('thongbao','Bạn đã sửa thành công');
   }


   public function getThem() {
   	return view('admin.tacgia.them');
   }
   
   public function postThem(Request $req) {
         $this->validate($req, 
            [
               'name' => 'required|unique:author,name|min:3|max:200'
            ],
            [
               'name.required' => 'Bạn chưa nhập tên ebook', 
               'name.unique' => 'ten thể loại đã tồn tại',
               'name.min' => 'Tên ebook tối thiểu 3 ký tự.', 
               'name.max' => 'Tên ebook tối đa 200 ký tự.'
            ]);
         $au = new tblauthor();
         $au->name = $req->name;
         //$new_str = utf8tourl(utf8convert($req->name));
         //echo $new_str;
         $au->save();

         return redirect('admin/tacgia/them')->with('thongbao','Bạn đã thêm thành công');
   }

   public function getXoa($id){
      $au = tblauthor::find($id);
      if(count($au->author_ebook)> 0)
      {
         return redirect('admin/tacgia/danhsach')->with('thongbao','Tác giả này có ebook.');
      }else{
         $au->delete();
         return redirect('admin/tacgia/danhsach')->with('thongbao','Bạn đã xóa thành công');
      }
   }
  
}
