<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class cashierController extends Controller
{
    public function dashboardPage()
    {
        return view('cashier/dashboard');
    }
}
