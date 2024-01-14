<?php

namespace App\Http\Controllers;

use App\Http\Requests\addAdminRequest;
use App\Models\admin;
use App\Models\pharmacy;
use App\Models\superAdminModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class superAdminController extends Controller
{
    public function dashboardPage()
    {
        $superAdminId = Auth::id(); 
        $superAdmin = superAdminModel::with('pharmacies.orders')->get();

        return view('superAdmin/dashboard',compact('superAdmin'));
    }

    public function pharmacyDetails(Request $request)
    {
        $phy_id = $request->input('phy_id');

        $pharmacy=Pharmacy::with([ 'orders.orderDetails.medicine','orders.orderDetails.cashier.user'])
        ->where('id', '=', $phy_id)
        ->first();

        return view('superAdmin/pharmacyDetilas',compact('pharmacy'));
    }

    public function pharmacyInfo(Request $request)
    {
        $phy_id=$request->id;
        $info=pharmacy::where('id','=',$phy_id)->update([
            'name'=>$request->name,
            'location'=>$request->location,
            'number'=>$request->number
        ]);
        return redirect()->back()->with('success','updated successfully');
    }

    public function adminsPage()
    {
        $pharmacy=pharmacy::with('admins.user')->get();
        
        return view('superAdmin/admins',compact('pharmacy'));
    }

    public function addAdmin(addAdminRequest $request)
    {
        $pharmacy_id=$request->pharmacy_id;
        $name=$request->firstName.' '.$request->secondName;
        $user=User::create([
            'name'=>$name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>'admin',
        ]);

        $cashier=admin::create([
            'user_id'=>$user->id,
            'pharmacy_id'=>$pharmacy_id,
        ]);
 
        Alert::success('Registerd successfully','welcome');

        return redirect()->back();
    }

    public function settingsPage()
    {
        $superAdmin=superAdminModel::with('user')->where('id','=','1')->first();
        
       return view('superAdmin.settings',compact('superAdmin'));
    }

    public function updateFunction(Request $request)
    {
        $user = user::find('13');//id for the suerAdmin
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255'
            ],
            'old_password' => 'required',
            'newPassword' => 'nullable|min:8|confirmed',
        ]);

        if (!Hash::check($request->old_password, $user->password))
        {
            return redirect()->back()->with('error', 'Old password is incorrect.');
        }

        $user->name = $request->name;
        $user->email = $request->email;

        // Check if a new password is provided
        if ($request->newPassword)
        {
            $user->password=hash::make($request->newPassword);
        }

        $user->save();

        return redirect()->back()->with('success', 'User information updated successfully.');

    }
}
