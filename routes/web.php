<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

//route login/register
Auth::routes();

//prefix (them tien to cho url): admin/student-list
//middleware("auth"): yeu cau dang nhap moi vao duoc trang chu
//middleware("isAdmin"): phan quyen, co tk admin moi co quyen truy cap admin

Route::middleware(["auth","isAdmin"])->prefix("admin")->group(function (){
    include_once "admin.php";
});

Route::middleware(["auth"])->group(function (){
    include_once "user.php";
});

//log_out
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

