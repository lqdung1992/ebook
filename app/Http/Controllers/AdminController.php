<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbladmin;
use App\User;
use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
{
    function __construct(){

    }

    public function getDashboard(){
        return view('admin.dashboard');
    }

    public function getLoginAdmin(){
            return view('admin.login');
        }

    public function postLoginAdmin(Request $req){
       $this->validate($req,
            [
                'mail'=>'required|email', 
                'password'=>'required|min:6|max:32'
            ],
            [
                'mail.required'=>'Vui lòng nhập địa chỉ email của bạn!',
                'mail.email'=>'Không đúng định dạng mail',
                'password.required'=>'Vui lòng nhập password',
                'password.min'=>'Mật khẩu ít nhất 6 ký tự.',
                'password.max'=>'mật khẩu không quá 32 ký tự.'
            ]
        );
        
        if(Auth::attempt(['email'=>$req->mail,'password'=>$req->password])){
            if(Auth::user()->role==0){
                return redirect('admin/dashboard');
            }else return redirect('admin')->with('thongbao','Đăng nhập không thành công');
        }
    }

    public function logout(){
        Auth::logout();
        return view('admin.login');
    }


//------------------PROFILE---------------------------
    public function getProfile($id){
        $ad = User::find($id);
        return view('admin.user.profile',['admin'=> $ad]);
    }

    public function postProfile(Request $req, $id) {
         $ad = User::find($id);
         $this->validate($req, 
            [
               'name' => 'required|unique:admin,name|min:3|max:200',
               'email' => 'required|email',
            ],
            [
               'name.required' => 'Bạn chưa nhập tên thể loại', 
               'name.min' => 'Tên thể loại tối thiểu 3 ký tự.', 
               'name.max' => 'Tên thể loại tối đa 200 ký tự.',
               'mail.required'=>'Vui lòng nhập địa chỉ email của bạn!',
              'mail.email'=>'Không đúng định dạng mail',
            ]);
         $ad->name = $req->name;
         $ad->email = $req->email;
         $ad->save();

         return redirect('admin/user/profile/'.$id)->with('thongbao','Bạn đã sửa thành công');
    }


    

//-------------------USER -----------------------------
    public function getDanhSach(){
        $user = User::all();
        return view('admin.user.danhsach',['user' => $user]);
    }

    public function getXem($id) {
      $ad = User::find($id);    
      return view('admin.user.xem', ['user'=>$ad]);
    }


    public function test(){
        $test = User::find(1)->hire;
        return view('admin/test',['test'=>$test]);
    } 
}
