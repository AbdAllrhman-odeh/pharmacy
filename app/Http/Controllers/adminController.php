<?php

namespace App\Http\Controllers;

use App\Http\Requests\addCashierRequest;
use App\Models\admin;
use App\Models\cashier;
use App\Models\order;
use App\Models\pharmacy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class adminController extends Controller
{
    public function dashboardPage()
    {
        //get the user_id
        $user_id = Auth::id();

        //get the pharmacy_id
        $pharmacy_id=admin::where('user_id','=',$user_id)->first();
        $pharmacy_id=$pharmacy_id->pharmacy_id;

        //get all pharmacy Info with the orders and orderDetails[with the medicine and the cashier information]
        $pharmacy = Pharmacy::with([ 'orders.orderDetails.medicine','orders.orderDetails.cashier.user'])
        ->where('id', '=', $pharmacy_id)
        ->first();

        // cashiers and admin info in this pharamcy
        $cashiers = $pharmacy->cashiers;
        $admins = $pharmacy->admins;
        // dd($pharmacy);
        return view('admin/dashboard',compact('pharmacy','cashiers','admins'));
    }

    public function addCashierPage()
    {
        //get the id 
        $user_id = Auth::id();

        $pharmacy_id=admin::where('user_id','=',$user_id)->first();
        $pharmacy_id=$pharmacy_id->pharmacy_id;

        //pharmacy got the cahsiers and their users table
        $pharmacy = Pharmacy::with('cashiers.user')
        ->where('id', '=', $pharmacy_id)
        ->first();

        return view('admin/addCashier',compact('pharmacy'));
    }

    public function addCashier(addCashierRequest $request)
    {

        //get the id 
        $user_id = Auth::id();

        //get the pharmacy_id
        $pharmacy_id=admin::where('user_id','=',$user_id)->first();
        $pharmacy_id=$pharmacy_id->pharmacy_id;

        $name=$request->firstName.' '.$request->secondName;
        $user=User::create([
            'name'=>$name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>'cashier',
        ]);

        $cashier=cashier::create([
            'user_id'=>$user->id,
            'pharmacy_id'=>$pharmacy_id,
        ]);

        Alert::success('Registerd successfully','welcome');

        return redirect()->back();
    }

}
