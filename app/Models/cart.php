<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    use HasFactory;

    public $table="carts";

    protected $fillable=[	 
        'pharmacy_id','cashier_id','medicine_id','quantity'
    ];

    protected $hidden="";

    // public function pharmacy()
    // {
    //     return $this->belongsTo(Pharmacy::class,'pharmacy_id','id');
    // }

    // public function cashier()
    // {
    //     return $this->belongsTo(Cashier::class,'cashier_id','id');
    // }

    public function medicines()
    {
        return $this->belongsTo(medicine::class,'medicine_id','id');
    }
}
