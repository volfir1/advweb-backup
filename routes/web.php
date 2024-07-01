<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get("/home",[HomeController::class,"index"]);
Route::get("/log",[HomeController::class,"log"]);

//Admin Routes
Route::get('/admin',[AdminController::class,'index']);
Route::get('/charts',[AdminController::class,'charts']);
Route::get('/tables',[AdminController::class,'tables']);
Route::get('/users',[AdminController::class,'users']);

//Auth Routes
Route::get('/login',[AuthController::class,'login']);
Route::get('/signup',[AuthController::class,'signup']);
Route::post('/register-user',[AuthController::class,'registerUser'])->name('register-user');
Route::post('/authenticate',[AuthController::class,'authenticate'])->name('authenticate');