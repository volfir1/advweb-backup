<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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

Route::get("/home",[HomeController::class,"home"]);
Route::get("/log",[HomeController::class,"log"]);


//Admin Routes
Route::middleware(['auth', 'is_admin'])->group(function () {
Route::get('admin/dashboard',[AdminController::class,'index'])->name('Dashboard.index');
Route::get('/charts', [AdminController::class, 'charts']);
Route::get('/tables', [AdminController::class, 'tables']);
Route::get('/users', [AdminController::class, 'users']);
});


Route::middleware(['auth', 'is_customer'])->group(function () {
Route::get('customer/dashboard',[CustomerController::class,'dashboard'])->name('customer.menu.dashboard');
    // Other customer routes...
});




//Auth Routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/signup', [AuthController::class, 'signup'])->name('signup');
Route::post('/register-user',[AuthController::class,'registerUser'])->name('register-user');
Route::post('/authenticate',[AuthController::class,'authenticate'])->name('authenticate');