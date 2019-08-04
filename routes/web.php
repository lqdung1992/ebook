<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use \App\Ebook;
Route::get('demo',function(){
    $tag_id = 1;
    $attributes = 2;
    $article = Ebook::find($attributes);
    $article->Library()->attach($tag_id);
    
    //$ebook->Library()->updateExistingPivot($tag_id, $attributes);
    //echo $article;
    return $article; 
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//-----------------------website------------------------------------------------------------
//-------HEADER MENU------------------
Route::get('/', 'PageController@getTrangChu');
Route::get('trangchu', 'PageController@getTrangChu' );
Route::get('ebook', 'PageController@getEbook' );
Route::get('vechungtoi','PageController@vechungtoi');
Route::get('chinhsach','PageController@chinhsach');

Route::get('lienhe','PageController@lienhe');
Route::post('lienhe','PageController@postlienhe');




//ROUTE GROUP ADMIN -------------------------------------------------------------------------
Route::group(['prefix'=>'admin', 'middleware'=>'CheckLogin'], function(){
	
	Route::get('dashboard','AdminController@getDashboard');

	Route::group(['prefix'=>'theloai'], function(){
		Route::get('danhsach','TheLoaiController@getDanhSach');

		Route::get('sua/{id}','TheLoaiController@getSua');
		Route::post('sua/{id}','TheLoaiController@postSua');

		Route::get('them','TheLoaiController@getThem');
		Route::post('them','TheLoaiController@postThem');

		Route::get('xoa/{id}', 'TheLoaiController@getXoa');
	});

	Route::group(['prefix'=>'ngonngu'], function(){
		Route::get('danhsach','NgonNguController@getDanhSach');

		Route::get('sua/{id}','NgonNguController@getSua');
		Route::post('sua/{id}','NgonNguController@postSua');

		Route::get('them','NgonNguController@getThem');
		Route::post('them','NgonNguController@postThem');

		Route::get('xoa/{id}', 'NgonNguController@getXoa');
	});

	Route::group(['prefix'=>'tacgia'], function(){
		Route::get('danhsach','TacGiaController@getDanhSach');

		Route::get('sua/{id}','TacGiaController@getSua');
		Route::post('sua/{id}','TacGiaController@postSua');

		Route::get('them','TacGiaController@getThem');
		Route::post('them','TacGiaController@postThem');

		Route::get('xoa/{id}', 'TacGiaController@getXoa');
	});

	Route::group(['prefix'=>'nhaxuatban'], function(){
		Route::get('danhsach','NhaXuatBanController@getDanhSach');

		Route::get('sua/{id}','NhaXuatBanController@getSua');
		Route::post('sua/{id}','NhaXuatBanController@postSua');

		Route::get('them','NhaXuatBanController@getThem');
		Route::post('them','NhaXuatBanController@postThem');

		Route::get('xoa/{id}', 'NhaXuatBanController@getXoa');
	});

	Route::group(['prefix'=>'ebook'], function(){
		Route::get('danhsach','EbookController@getDanhSach');

		Route::get('sua/{id}','EbookController@getSua');
		Route::post('sua/{id}','EbookController@postSua');

		Route::get('them','EbookController@getThem');
		Route::post('them','EbookController@postThem');

		Route::get('xoa/{id}','EbookController@getXoa');
	});

	Route::group(['prefix'=>'thongke'], function(){
		Route::get('xem/{idDanhMuc}','ThongKeController@getThongKe');
		Route::get('xem','ThongKeController@getXem');
		Route::post('xem',['as'=>'post-xem-thongke','uses'=>'ThongKeController@postXem']);


		Route::get('tientheongay','ThongKeController@getTien');
		Route::post('tientheongay','ThongKeController@postTien');
	});

	Route::group(['prefix'=>'user'], function(){
		Route::get('profile/{id}','AdminController@getProfile');
		Route::post('profile/{id}','AdminController@postProfile');

		Route::get('danhsach','AdminController@getDanhSach');

		Route::get('xem/{id}','AdminController@getXem');

		Route::get('sua/{id}','AdminController@getSua');
		Route::post('sua/{id}','AdminController@postSua');

		Route::get('xoa/{id}', 'AdminController@getXoa');
	});

	
});

//dang nhap admin-----------------------------------------------------------------------------------
Route::get('admin','AdminController@getLoginAdmin');
Route::post('admin','AdminController@postLoginAdmin');
Route::get('logout','AdminController@logout');

Route::get('admin/test','AdminController@test');



//---------------------------------------------------------------------------------------------



//	ROUTE DANG KY- DANG NHAP USER-------------------------------------------------------------------
Route::get('dangky', 'UserController@getDangKy');
Route::post('dangky','UserController@postDangKy');



Route::get('dangnhap', 'UserController@getDangNhap');
Route::post('dangnhap', 'UserController@postDangNhap');
Route::get('dangxuat', 'UserController@logout');

Route::get('thongtin','UserController@getThongTin');
Route::post('thongtin/{id}','UserController@postThongTin');

Route::get('doipass','UserController@getDoiPass');
Route::post('doipass/{id}','UserController@postDoiPass');

Route::get('laylaimatkhau','UserController@getLayLaiMK');
Route::post('laylaimatkhau','UserController@postLayLaiMK');

Route::get('naptien','UserController@getNapTien');
Route::post('naptien/{id}','UserController@postNapTien');

Route::post('themthuvien/{id}','UserController@themThuVien');
Route::get('xoathuvien/{id}','UserController@xoaThuVien');

Route::get('thuvien','UserController@getThuVien');
//---------------------------------------------------------------------------------------------


//--------------------------------------------------------------------------------------------
Route::get('read','EbookController@read');

Route::get('loaiebook/{idT}/{id}','PageController@getNhaXuatBan');

Route::get('chitietebook/{id}',[
	'as' => 'chitietebook',
	'uses' => 'PageController@getChiTiet'
]);


Route::post('timkiem','PageController@timkiem');
//Route::get('testpdf','PageController@convertPDF');
//Route::get('testpdf/{id}/{bookmark}', 'PageController@convertText');

Route::get('doc/{id}/{pageNum}', ['as' => 'doc', 'uses' => 'PageController@convertPDF']);
//Route::get('doc/{id}/{pageNum}', ['as' => 'doc', 'uses' => 'PageController@convertPDF']);
Route::get('read-pdf-linux/{urlFileName}/{pageNum}', ['as' => 'read-pdf-linux', 'uses' => 'PageController@readOnLinux']);


//-----------------SET PASSWORD--------------------------------------------------
use App\tbluser;
Route::get('test',function(){
	$users = tbluser::all();
	foreach ($users as $v) {
		$v->password = bcrypt('123456');
		$v->save();
	}
	echo "Them du lieu thanh cong";
});


