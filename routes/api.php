<?php

use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EbookController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// route login & register: khong middkeware
Route::post('/login', 'LoginController@login');
Route::post('/signup', 'LoginController@signup');

// route can middleware
Route::middleware('auth:api')->post('/logout', 'LoginController@logout');

// ebook list
Route::middleware('auth:api')->get('/ebook', 'EbookController@getList');
// tìm kiếm
Route::middleware('auth:api')->post('/ebook', 'EbookController@getList');

// thuê ebook
Route::middleware('auth:api')->post('/ebook/rent', 'EbookController@rentEbook');

// 1 user làm sao create 1 user khác: bỏ, tạo thì để trên signup kìa
//Route::post('/user', 'UserController@create'); // create user

// get user info
Route::middleware('auth:api')->match(['GET', 'POST'], '/user', 'UserController@getUserInfo');

// update thông tin cá nhân thì không cần id, vì có token rồi
Route::middleware('auth:api')->post('/user/edit', 'UserController@update'); // update user

// doc sach
Route::middleware('auth:api')->post("/user/read", 'UserController@readEbook');

// get ebook đã thuê
Route::middleware('auth:api')->post('/user/ebook', 'UserController@getRentEbook');

// them vao library
Route::middleware('auth:api')->post('/user/library/add', 'UserController@addLibrary');
// xoa library
Route::middleware('auth:api')->post('/user/library/remove', 'UserController@removeLibrary');

// lay ds the loại
Route::middleware('auth:api')->get('/type', 'EbookController@getType');


//Route::get('/user', 'UserController@index'); // all user

// 1 user không cho get 1 user khác
//Route::get('/user/{id}', 'UserController@show'); //

// tự xóa tài khoản???
// Route::delete('/user/{id}', 'UserController@destroy');
