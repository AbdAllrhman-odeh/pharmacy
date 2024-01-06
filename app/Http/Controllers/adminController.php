<?php

namespace App\Http\Controllers;

use App\Models\admin;

use Illuminate\Http\Request;

class adminController extends Controller
{
    public function dashboardPage()
    {
        $info = Admin::with(['user','pharmacy','order'])->first();
        return view('admin/dashboard',compact('info'));
    }
}
