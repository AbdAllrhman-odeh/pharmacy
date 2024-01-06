<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;

    public $table="orders";

    protected $fillable=[
        'cashier_id',
        'pharmacy_id',
    ];

    protected $hidden="";

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class,'pharmacy_id','id');
    }

    public function orderDetails()
    {
        return $this->hasMany(order_detalis::class,'order_id','id');
    }
}
