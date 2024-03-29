<?php

namespace App\Http\Controllers;

use App\Http\Requests\addCashierRequest;
use App\Models\admin;
use App\Models\alternative_medicine;
use App\Models\cashier;
use App\Models\medicine;
use App\Models\order;
use App\Models\pharmacy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class adminController extends Controller
{

    public function getPhyId()
    {
        //get the user_id
        $user_id = Auth::id();

        //get the pharmacy_id
        $pharmacy_id=admin::where('user_id','=',$user_id)->first();
        $pharmacy_id=$pharmacy_id->pharmacy_id;
        return $pharmacy_id;
    }

    public function dashboardPage()
    {
        //get the user_id
        $user_id = Auth::id();

        //get the pharmacy_id
        $pharmacy_id=admin::where('user_id','=',$user_id)->first();
        $pharmacy_id=$pharmacy_id->pharmacy_id;

        // //get all pharmacy Info with the orders and orderDetails[with the medicine and the cashier information]
        // $pharmacy = Pharmacy::with([ 'orders.orderDetails.medicine','orders.orderDetails.cashier.user'])
        // ->where('id', '=', $pharmacy_id)
        // ->first();

        $pharmacy = Pharmacy::with([
            'orders' => function ($query) {
                $query->orderBy('created_at', 'desc'); // or 'asc' for ascending order
            },
            'orders.orderDetails.medicine',
            'orders.orderDetails.cashier.user'
        ])
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

    public function addDrugPage()
    {
            //get the id 
            $user_id = Auth::id();

            $pharmacy_id=admin::where('user_id','=',$user_id)->first();
            $pharmacy_id=$pharmacy_id->pharmacy_id;
    
            $pharmacy = Pharmacy::with(['medicines' => function ($query) {
                $query->orderBy('quantity', 'asc'); 
            }])
            ->where('id', '=', $pharmacy_id)
            ->first();
            
        
            return view('admin/addDrug',compact('pharmacy'));
    }

    public function updateMedicine(Request $request,$medicine_id)
    {
        $info=medicine::where('id','=',$medicine_id)->update([
            'name'=>$request->new_name,
            'chemical_Name'=>$request->new_chemical_name,
            'does'=>$request->new_does,
            'type'=>$request->new_type,
            'quantity'=>$request->new_quantity,
            'price'=>$request->new_price,
            'exp_date'=>$request->new_exp_date,
            'mfg_date'=>$request->new_mfg_date
        ]);
        Alert::success('Updated successfully');
        return redirect()->back();
    }

    public function dd(Request $request)
    {
        $phy_id=$this->getPhyId();
        $medicine_id=$request->medicine_id;
        
        //delete the alternative medicines
        $flag=alternative_medicine::
            where('pharmacy_id','=',$phy_id)
            ->where('original_medicine_id','=',$medicine_id)
            ->delete();

        $flag=alternative_medicine::
            where('pharmacy_id','=',$phy_id)
            ->where('alternative_medicine_id','=',$medicine_id)
            ->delete();

        $info=medicine::where('id','=',$medicine_id)->delete();
        return redirect()->back()->with('msg','deleted successfully');
    }



    //function to add medicine
    public function addMedicine(Request $request)
    {
        $phy_id=$this->getPhyId();
        $info=medicine::create([
            'name'=>$request->name,
            'chemical_Name'=>$request->chemical_Name,
            'does'=>$request->does,
            'type'=>$request->type,
            'quantity'=>$request->quantity,
            'price'=>$request->price,
            'exp_date'=>$request->exp_date,
            'mfg_date'=>$request->mfg_date,	
            'pharmacy_id'=>$phy_id,
        ]);

        return redirect()->back()->with('msgAdd','Add successfully');
    }

    public function myStorePage()
    {
        return view('admin.myStore');
    }

    public function searchMethod(Request $request)
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
            return redirect()->to('admin/addDrug')->with('msgEmpty','empty set');

            return view('admin.addDrug',compact('pharmacy','filteredData'));
        }
        else
        {
            return view('admin.addDrug', compact('pharmacy'));
        }

    }

    public function orderHistoryPage()
    {
        $phy_id=$this->getPhyId();

        //get all pharmacy Info with the orders and orderDetails[with the medicine and the cashier information]
        $pharmacy = Pharmacy::with([ 'orders.orderDetails.medicine','orders.orderDetails.cashier.user'])
        ->where('id', '=', $phy_id)
        ->first();
        
        return view('admin.orderHistory',compact('pharmacy'));
    }

    public function searchMethodForOrder(Request $request)
    {
        $phy_id=$this->getPhyId();

        //get all pharmacy Info with the orders and orderDetails[with the medicine and the cashier information]
        $pharmacy = Pharmacy::with([ 'orders.orderDetails.medicine','orders.orderDetails.cashier.user'])
        ->where('id', '=', $phy_id)
        ->first();
        
        $searchQuery=$request->search;
        $phy_id=$this->getPhyId();
    
        if($searchQuery!=' ')
        {
            $filteredData = order::with(['orderDetails.medicine','orderDetails.cashier.user'])->where('pharmacy_id', '=', $phy_id)
            ->where(function ($query) use ($searchQuery) {
                $query->where('id', 'like', '%' . $searchQuery . '%');
            })
            ->get();



            if($filteredData->isEmpty())// && $filteredDataMedicine->isEmpty())
            return redirect()->to('admin/orderHistory')->with('msgEmpty','empty set');

            else if(!($filteredData->isEmpty()))
            return view('admin.orderHistory',compact('pharmacy','filteredData'));

            // else if( !($filteredDataMedicine->isEmpty()) )dd($filteredDataMedicine);
            // return view('admin.orderHistory',compact('pharmacy','filteredDataMedicine'));

            
            return view('admin.orderHistory', compact('pharmacy'));
        }
        else
        {
            return view('admin.orderHistory', compact('pharmacy'));
        }
        return view('admin.orderHistory', compact('pharmacy'));   
    }

    public function settingsPage()
    {
        $user_id = Auth::id();
        $admin=user::where('id','=',$user_id)->first();
        
       return view('admin.settings',compact('admin'));
    }

    public function updateFunction(Request $request)
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

    public function alternativeMedicines()
    {
        $phy_id=$this->getPhyId();
        $medicines=medicine::where('pharmacy_id','=',$phy_id)->get();

        $info=alternative_medicine::with('originalMedicine','alternativeMedicine')->where('pharmacy_id','=',$phy_id)->get();

        return view('admin.alternativeMedicines',compact('medicines','info'));
    }

    public function alternativeFunction(Request $request)
    {
        $phy_id=$this->getPhyId();
        $originalMedicine=$request->originalMedicine;
        $alternativeMedicine=$request->alternativeMedicine;

        //search if it is exists
        $flag=alternative_medicine::
            where('original_medicine_id','=',$originalMedicine)
            ->where('alternative_medicine_id','=',$alternativeMedicine)
            ->where('pharmacy_id','=',$phy_id)
            ->get();
        
        if(count($flag)!=0)
        {
            //record exists
            return redirect()->back()->with('error', 'This Record Exsits!');
        }    

        if($originalMedicine==$alternativeMedicine)
        {
            return redirect()->back()->with('error', 'same medicines id');
        }
        $info=alternative_medicine::create([
            'original_medicine_id'=>$originalMedicine,
            'alternative_medicine_id'=>$alternativeMedicine,
            'pharmacy_id'=>$phy_id
        ]);

        if($info)
        {
            return redirect()->back()->with('success', 'Added Alternative Successfully');
        }
        return redirect()->back()->with('error', 'Error: Falid to create new record');

    }

    public function deleteAlt(Request $request)
    {
        $phy_id=$this->getPhyId();
        $info=alternative_medicine::
            where('original_medicine_id','=',$request->originalMedId)
            ->where('alternative_medicine_id','=',$request->alternativeMedId)
            ->where('pharmacy_id','=',$phy_id)
            ->delete();
        
        if($info)
        {
            return redirect()->back()->with('success', 'Deleted Successfully');
        }
        return redirect()->back()->with('error', 'Error: Delteing the alternative medicines falieds');
    }

}
