<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function dashboard(){
        return view('customer.menu.dashboard');
    }

    public function cart(){
        return view('customer.cart');
    }
}
