<?php

namespace App\Http\Controllers;

use App\Http\Requests\addCashierRequest;
use App\Models\admin;
use App\Models\cashier;
use App\Models\order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

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

    public function addCashierPage()
    {
        //info with pharmacy table is important bc when we add a new cashier,we need to 
        // know what pharamcy he was added 
        $info=Admin::with(['pharmacy'])->first();
        return view('admin/addCashier',compact('info'));
    }

    public function addCashier(addCashierRequest $request,$pharamcy_id)
    {

        $name=$request->firstName.' '.$request->secondName;
        $user=User::create([
            'name'=>$name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>'cashier',
        ]);

        $cashier=cashier::create([
            'user_id'=>$user->id,
            'pharmacy_id'=>$pharamcy_id,
        ]);

        Alert::success('Registerd successfully','welcome');

        return redirect()->back();
    }

}
