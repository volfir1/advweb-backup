<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function index(){
        return view('admin.index');
    }

    public function charts(){
        return view('Dashboard.pages.charts.chartjs');
    }

    public function tables(){
        return view('Dashboard.pages.tables.table');
    }

    public function users(){
        return view('Dashboard.pages.users.users');
    }
}