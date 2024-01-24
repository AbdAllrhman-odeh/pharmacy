<?php

namespace App\Http\Controllers;

use App\Models\alternative_medicine;
use App\Models\cart;
use App\Models\cashier;
use App\Models\medicine;
use App\Models\order;
use App\Models\order_detalis;
use App\Models\pharmacy;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Type\Integer;

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

    public function getMedicineName($id)
    {
        $name=medicine::where('id','=',$id)->first();
        $name=$name->name;

        return $name;
    }

    public function MedcicinesPage()
    {
        $pharmacy_id=$this->getPhyId();

        //pharmacy got the cahsiers and their users table
        $pharmacy = pharmacy::with('medicines')
        ->where('id', '=', $pharmacy_id)
        ->first();
        $alternatives=alternative_medicine::where('pharmacy_id','=',$pharmacy_id)->get();
                
        return view('cashier/medicines',compact('pharmacy','alternatives'));
        // return view('cashier.medicines');
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

    public function getCart()
    {
        $pharmacy_id=$this->getPhyId();
        $user_id = Auth::id();
        $cashier_id=cashier::where('user_id','=',$user_id)->first();
        $cashier_id=$cashier_id->id;

        $cart=cart::with('medicines')
        ->where('pharmacy_id','=',$pharmacy_id)
        ->where('cashier_id','=',$cashier_id)
        ->get();

        return $cart;
    }

    public function sellMedicinesPage()
    {
        $cart=$this->getCart();

        return view('cashier.sellMedicines',compact('cart'));
    }

    public function addToCart(Request $request)
    {
        $pharmacy_id=$this->getPhyId();
        $user_id = Auth::id();
        $cashier_id=cashier::where('user_id','=',$user_id)->first();
        $cashier_id=$cashier_id->id;
        
        $medicine_id=$request->med_id;
        $medicine_quantity=$request->med_quantity;
        
        if($medicine_quantity>0)
        {
            $checkCart=$this->getCart();
            $flag=cart::where('pharmacy_id','=',$pharmacy_id)
                ->where('cashier_id','=',$cashier_id)
                ->where('medicine_id','=',$medicine_id)
                ->first();
                
                if($flag)
                {
                    //[1] Medicine Exists on the cart

                    //handle the quantity
                    $newQuantity=$flag->quantity+$medicine_quantity;

                    cart::where('pharmacy_id','=',$pharmacy_id)
                    ->where('cashier_id','=',$cashier_id)
                    ->where('medicine_id','=',$medicine_id)
                    ->update([
                        'quantity'=>$newQuantity,
                    ]);

                    //get the medicine name
                    $name=$this->getMedicineName($flag->medicine_id);

                    return redirect()->to('cashier/sellMedicines')->with('updateCart',$name);
                }

                // [2] Medicine does not exists on the cart
            cart::create([
                'pharmacy_id'=>$pharmacy_id,
                'cashier_id'=>$cashier_id,
                'medicine_id'=>$medicine_id,
                'quantity'=>$medicine_quantity,
            ]);

            $cart=cart::with('medicines')
                ->where('pharmacy_id','=',$pharmacy_id)
                ->where('cashier_id','=',$cashier_id)
                ->get();

            return view('cashier.sellMedicines',compact('cart'));
        }
        else
        {
            return redirect()->back()->with('qunatityErorr','qunatity less that zero');
        }
    }

    public function checkOut()
    {
        $cart=$this->getCart();

        $pharmacy_id=$this->getPhyId();
        $user_id = Auth::id();
        $cashier_id=cashier::where('user_id','=',$user_id)->first();
        $cashier_id=$cashier_id->id;

        //[1] Create an order
        $order=order::create([
            'cashier_id'=>$cashier_id,
            'pharmacy_id'=>$pharmacy_id,
        ]);

        $order_id = $order->id;

        //[2] Create an orderDetails
        foreach($cart as $cartItem)
        {
            $phy_id=$cartItem->pharmacy_id;
            $med_id=$cartItem->medicine_id;
            $cash_id=$cartItem->cashier_id;
            $quantity=$cartItem->quantity;

            if($phy_id==$pharmacy_id && $cashier_id==$cash_id)
            {
                order_detalis::create([
                    'order_id'=>$order_id,
                    'medicine_id'=>$med_id,
                    'cashier_id'=>$cash_id,
                    'quantity'=>$quantity,
                ]);
                
                //[3] Update the medicine quantity
                    //get the old quantity
                    $old_quantity=medicine::where('id','=',$med_id)->first();
                    $old_quantity=$old_quantity->quantity;

                    $new_medicine_quantity=$old_quantity-$quantity;

                    //check if the medicine has become out of stock
                    if($new_medicine_quantity==0)
                    {
                        //delete the medicine from the db
                        //or soft delete
                        medicine::where('id','=',$med_id)->delete();
                    }
                    //medicine is not out of stock
                    else
                    {
                        medicine::where('id','=',$med_id)->update([
                            'quantity'=>$new_medicine_quantity
                        ]);
                    }
            }
          
        }

        //[4] Delete the order from the cart
        foreach($cart as $cartItem)
        {
            $phy_id=$cartItem->pharmacy_id;
            $med_id=$cartItem->medicine_id;
            $cash_id=$cartItem->cashier_id;
            $quantity=$cartItem->quantity;

            if($phy_id==$pharmacy_id && $cashier_id==$cash_id)
            {
                cart::where('pharmacy_id','=',$pharmacy_id)
                    ->where('cashier_id','=',$cashier_id)
                    ->delete();
            }
          
        }
        return redirect()->to('cashier/sellMedicines')->with('yes','asdf adsf');
        return view('cashier.sellMedicines');
    }

    public function editCart(Request $request)
    {
        cart::where('id','=',$request->cart_id)->update([
            'quantity'=>$request->newQuantity
        ]);

        $cart=cart::where('id','=',$request->cart_id)->first();
        $med_id=$cart->medicine_id;
        $med_name=medicine::where('id','=',$med_id)->first();
        $med_name=$med_name->name;

        return redirect()->to('cashier/sellMedicines')->with('updateCart',$med_name);
    }

    public function deleteMedicine(Request $request)
    {
        $cart=cart::where('id','=',$request->cart_id)->first();
        $med_id=$cart->medicine_id;
        $med_name=medicine::where('id','=',$med_id)->first();
        $med_name=$med_name->name;

        cart::where('id','=',$request->cart_id)->delete();

        return redirect()->to('cashier/sellMedicines')->with('deleteMedicine',$med_name);
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
            
            $cart=$this->getCart();

            return view('cashier/sellMedicines',compact('filteredData','cart'));
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

        // $orders=cashier::with('orders.orderDetails.medicine')
        // ->where('user_id','=',$user_id)
        // ->first();

        $orders = cashier::with(['orders' => function ($query) {
            $query->orderBy('created_at', 'desc'); 
        }, 'orders.orderDetails.medicine'])
        ->where('user_id', '=', $user_id)
        ->first();
    

        return view('cashier.orderHistory',compact('orders'));
    }

    public function liveSearchTable(Request $request)
    {
        if($request->ajax()){
            // $data=order::with('orderDetails.medicine')
            //     ->where('created_at','like','%'.$request->search.'%')
            //     ->orWhere('id','like','%'.$request->search.'%')
            //     ->get();

            //search by order_id order_date or medicine name
            $data = order::with('orderDetails.medicine')
                ->where(function ($query) use ($request)
                {
                    $query->where('created_at', 'like', '%' . $request->search . '%')
                        ->orWhere('id', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('orderDetails.medicine', function ($query) use ($request)
                {
                    $query->where('name', 'like', '%' . $request->search . '%');
                })
                ->get();    



            $output='';
            if(count($data)>0)
            {
                $output='
                <table>
                <thead>
                <tr>
                    <th>Order Id</th>
                    <th>Date && Time</th>
                    <th>Medicine Details</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
                <tbody>';   
                foreach($data as $row)
                {
                    $output.='<tr>
                        <td>
                        '.$row->id.'
                        </td>
                        <td>Date:
                        '.$row->created_at->format('Y-m-d').'<br>Time:'.$row->created_at->format('H:i:s').'
                        </td><td>';
                        foreach($row->orderDetails as $orderDetails)
                        {
                            $output.='<b>'.$orderDetails->medicine->name.'</b>';
                            if($orderDetails->medicine->type == 'tablet')
                            {
                                $output.=' / '.$orderDetails->medicine->does.' MG';
                                $output.='<details>';
                                    $output.='<summary>More</summary>';
                                    $output.='<p><b>Id: '.$orderDetails->medicine->id.'</b></p>';
                                    $output.='<p><b>Price: $'.$orderDetails->medicine->id.'</b></p>';
                                    $output.='<p>Exp-date: '.$orderDetails->medicine->exp_date.'</p>';
                                    $output.='<p>MFG-date: '.$orderDetails->medicine->mfg_date.'</p>';
                                $output.='</details>';
                            }
                        }

                        $output.='</td><td>';
                        $total=0;
                        foreach($row->orderDetails as $orderDetails)
                        {
                            $output.='*('.$orderDetails->quantity.')<br>';
                            $total += $orderDetails->quantity * $orderDetails->medicine->price;
                        }
        

                        $output.='</td><td>$'.$total;
                    $output.='</td></tr>';
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

    public function liveSearchTableMedicines(Request $request)
    {
        if($request->ajax())
        {
            $filteredData=medicine::where('name','like','%'.$request->search.'%')
            ->orWhere('chemical_Name','like','%'.$request->search.'%')
            ->get();
            $output='';
            if(count($filteredData)>0)
            {
                return view('cashier/sellMedicines',compact('filteredData'));
                return ($filteredData);
            }
            else
            {
                $filteredData='no result found';
            }
            return $filteredData;
        }
    }


}