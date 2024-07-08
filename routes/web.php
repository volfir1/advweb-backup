<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ErrorController;
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
    Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'is_admin']], function() {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/orders', [AdminController::class, 'orders'])->name('orderindex');
        Route::get('/products', [AdminController::class, 'products'])->name('productindex');
        Route::get('/users', [AdminController::class, 'users'])->name('userindex');
        Route::get('/suppliers', [AdminController::class, 'suppliers'])->name('supplierindex');
        Route::get('/inventory', [AdminController::class, 'inventory'])->name('invetoryindex');
        
    });

Route::group(['prefix' => 'customer', 'middleware' => ['auth', 'is_customer']], function() {
    Route::get('/dashboard',[CustomerController::class,'dashboard'])->name('customer.menu.dashboard');

    // Add other routes specific to customers here...
});



Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::group(['prefix' => 'auth', 'middleware' => 'guest'], function() {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/signup', [AuthController::class, 'signup'])->name('signup');
    Route::post('/register-user', [AuthController::class, 'registerUser'])->name('register-user');
    Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
});


// routes/web.php
Route::post('/check-email', [AuthController::class, 'checkEmail'])->name('check-email');
Route::get('/user/profile', [AuthController::class, 'getUserProfile'])->name('user.profile')->middleware('auth');



//Auth Routes


//React routes
Route::get('/404', [ErrorController::class, 'error404'])->name('error.404');
Route::get('/403', [ErrorController::class, 'error403'])->name('error.403');