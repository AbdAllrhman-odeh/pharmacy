<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class homeController extends Controller
{
    //check the role of the user
    public function index()
    {
        //check if the user Signed in
        if(Auth::id())
        {
            //get the role of the user
            $role=Auth()->user()->role;

            if($role=='user')
            {
                //user is an cashier
                return view('cashiers.dashboard');
            }
            else if($role=='admin')
            {
                //admin is an cashier
                return view('admins.dashboard');
            }
            else if($role=='superAdmin')
            {
                //user is an superAdmin
                return view('superAdmin.dashboard');
            }
        }

        return redirect()->back();
    }

    public function create(Request $request)
    {
        $info=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>$request->role,
        ]);

        return 'done';
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
                return ('correct');
            }
        }
        return redirect()->back();
    }
}
