<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class homeController extends Controller
{

    public function create(Request $request)
    {
        $info=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>$request->role,
        ]);

        $role=$request->role;
        if($role=='superAdmin')
         {
            //superAdmin
            return redirect()->to('superAdmin/dashboard');
         }
         else if($role=='admin')
         {
            //admin
            return redirect()->to('admin/dashboard');
         }
         else if($role=='cashier')
         {
            //cashier
            return redirect()->to('cashier/dashboard');
         }
    }

    public function login(Request $request)
    {
        $validate=request()->validate([
            'email'=>'required',
            'password'=>'required',
        ]);
        if($validate)
        {
            $info=$request->only('email','password');
            if(Auth::attempt($info))
            {
               $role=Auth()->user()->role;

               if($role=='superAdmin')
               {
                    //superAdmin
                    return redirect()->to('superAdmin/dashboard');
               }
               else if($role=='admin')
               {
                    //admin
                    return redirect()->to('admin/dashboard');
               }
               else if($role=='cashier')
               {
                    //cashier
                    return redirect()->to('cashier/dashboard');
               }

            }
        }
        return redirect()->back();
    }
}
