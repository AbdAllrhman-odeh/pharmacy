<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class medicine extends Model
{
    use HasFactory;

    public $table="medicines";

    protected $fillable=[
        'name',
        'chemical_Name',
        'does',
        'type',
        'quantity',
        'price',
        'exp_date',
        'mfg_date',
        'pharmacy_id',
        'compnay_name',
    ];

    protected $hidden="";

    public function pharmacy()
    {
        return $this->belongsTo(pharmacy::class,'pharmacy_id','id');
    }
    
    public function orderDetails()
    {
        return $this->hasMany(order_detalis::class,'medicine_id','id');
    }
}
