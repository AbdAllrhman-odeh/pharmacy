<?php

namespace App\Http\Controllers;

use App\Models\pharmacy;
use App\Models\superAdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
