<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\order;
use Illuminate\Http\Request;

class adminController extends Controller
{
    public function dashboardPage()
    {

        $info=Admin::with(['user','pharmacy','order'])->first();

        $orders=order::with('orderDetails.medicine')
        ->where('pharmacy_id','=',$info->pharmacy->id)
        ->get();
       
        return view('admin/dashboard',compact('info','orders'));
    }
}
