<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\cashier;
use App\Models\medicine;
use App\Models\order;
use App\Models\order_detalis;
use App\Models\pharmacy;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class cashierController extends Controller
{   
    public function getPhyId()
    {
        //get the user_id
        $user_id = Auth::id();

        //get the pharmacy_id
        $pharmacy_id=cashier::where('user_id','=',$user_id)->first();
        $pharmacy_id=$pharmacy_id->pharmacy_id;
        return $pharmacy_id;
    }

    public function MedcicinesPage()
    {
        $pharmacy_id=$this->getPhyId();

        //pharmacy got the cahsiers and their users table
        $pharmacy = pharmacy::with('medicines')
        ->where('id', '=', $pharmacy_id)
        ->first();
                
        return view('cashier/medicines',compact('pharmacy'));
    }

    public function searchMethodForCashier(Request $request)
    {
        $pharmacy_id=$this->getPhyId();
        $pharmacy = Pharmacy::with('medicines')
        ->where('id', '=', $pharmacy_id)
        ->first();

        $searchQuery=$request->search;
        $phy_id=$this->getPhyId();
    
        if($searchQuery!=' ')
        {
            $filteredData = medicine::where('pharmacy_id', '=', $phy_id)
            ->where(function ($query) use ($searchQuery) {
                $query->where('name', 'like', '%' . $searchQuery . '%')
                ->orWhere('chemical_Name', 'like', '%' . $searchQuery . '%')
                ->orWhere('type', 'like', '%' . $searchQuery . '%')
                ->orWhere('exp_date', 'like', '%' . $searchQuery . '%')
                ->orWhere('mfg_date', 'like', '%' . $searchQuery . '%')
                ->orWhere('quantity', 'like', '%' . $searchQuery . '%');
            })
            ->get();
            if($filteredData->isEmpty())
            return redirect()->to('cashier/medicines')->with('msgEmpty','empty set');

            return view('cashier/medicines',compact('pharmacy','filteredData'));
        }
        else
        {
            return view('cashier/medicines', compact('pharmacy'));
        }

    }

    public function sellMedicinesPage()
    {
        return view('cashier.sellMedicines');
    }

    public function searchMethodCashier_sell(Request $request)
    {
        $pharmacy_id=$this->getPhyId();
        $pharmacy = Pharmacy::with('medicines')
        ->where('id', '=', $pharmacy_id)
        ->first();

        $searchQuery=$request->search;
        $phy_id=$this->getPhyId();
    
        if($searchQuery!=' ')
        {
            $filteredData = medicine::where('pharmacy_id', '=', $phy_id)
            ->where(function ($query) use ($searchQuery) {
                $query->where('name', 'like', '%' . $searchQuery . '%')
                ->orWhere('chemical_Name', 'like', '%' . $searchQuery . '%')
                ->orWhere('type', 'like', '%' . $searchQuery . '%')
                ->orWhere('exp_date', 'like', '%' . $searchQuery . '%')
                ->orWhere('mfg_date', 'like', '%' . $searchQuery . '%')
                ->orWhere('quantity', 'like', '%' . $searchQuery . '%');
            })
            ->get();
            if($filteredData->isEmpty())
            return redirect()->to('cashier/sellMedicines')->with('msgEmpty','empty set');
            
            $cart=cart::get();

            return view('cashier/sellMedicines',compact('filteredData'));
        }
        else
        {
            return view('cashier/sellMedicines');
        }

    }


    public function settingsPage()
    {
        $user_id = Auth::id();

        $cashier=User::where('id','=',$user_id)->first();
        
       return view('cashier.settings',compact('cashier'));
    }

    public function updateInfo(Request $request)
    {
        $user_id = Auth::id();
        $phy_id=$this->getPhyId();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user_id), // Ignore the current user id
            ],
            'old_password' => 'required',
            'newPassword' => 'nullable|min:8|confirmed',
        ]);

        $user = User::find($user_id);

        if (!Hash::check($request->old_password, $user->password))
        {
            return redirect()->back()->with('error', 'Old password is incorrect.');
        }

        $user->name = $request->name;
        $user->email = $request->email;

        // Check if a new password is provided
        if ($request->newPassword)
        {
            $user->password = bcrypt($request->newPassword);
        }

        $user->save();

        return redirect()->back()->with('success', 'User information updated successfully.');
    }


    public function orderHistoryPage()
    {
        $user_id = Auth::id();
        $phy_id=$this->getPhyId();

        $orders=cashier::with('orders.orderDetails.medicine')
        ->where('user_id','=',$user_id)
        ->first();

        return view('cashier.orderHistory',compact('orders'));
    }

    // public function ajax_search(Request $request)
    //     {
    //         if($request->ajax())
    //         {
    //             $phy_id = $this->getPhyId();
    //             $searchByAjax = $request->searchByAjax;
        
    //             try {
    //                 $data = medicine::where('name', 'like', '%' . $searchByAjax . '%')
    //                     ->where('pharmacy_id', '=', $phy_id)
    //                     ->get();
        
    //                 return view('cashier.ajax_search', ['data' => $data])->render();
    //             } catch (\Exception $e) {
    //                 // Log the exception or display the error message
    //                 dd($e->getMessage());
    //             }
    //         }
    //     }

    public function liveSearchTable(Request $request)
    {
        if($request->ajax()){
            $data=order::where('created_at','like','%'.$request->search.'%')
            ->orWhere('id','like','%'.$request->search.'%')
            ->get();
            $output='';
            if(count($data)>0)
            {
                $output='
                <table>
                <thead>
                    <tr>
                        <td>
                            id:
                        </td>
                        <td>
                            name:
                        </td>
                        <td>
                            Quantity:
                        </td>
                    </tr>
                </thead>
                <tbody>';
                foreach($data as $row)
                {
                    $output.='<tr>
                        <td>
                        '.$row->id.'
                        </td>
                        <td>
                        '.$row->created_at.'
                        </td>
                    </tr>';
                }
                $output.='</tbdoy></table>';
            }
            else
            {
                $output='no result found';
            }
            return $output;
        }
    }
        

}