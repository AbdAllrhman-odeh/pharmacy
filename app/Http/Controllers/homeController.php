<?php

namespace App\Http\Controllers;


use App\Http\Requests\signInRequest;
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

        return redirect()->to('signin');
    }

    public function login(signInRequest $request)
    {
        $rules = [
            'email' => 'required|email|min:5|max:30',
            'password' => 'required|string|min:5|max:20',
        ];
    
        $credentials = $request->validate($rules);
    
        if (Auth::attempt($credentials)) {
            $role = Auth()->user()->role;
            if($role=='cashier') return redirect()->to($role.'/medicines');
            return redirect()->to($role.'/dashboard');
        }
    
        return redirect()->back()->withErrors(['login' => 'Invalid credentials']);
    }
    }
    