<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class superAdminController extends Controller
{
    public function dashboardPage()
    {
        return view('superAdmin/dashboard');
    }
}
