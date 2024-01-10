<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class admin extends Model
{
    use HasFactory;

    public $table="admins";

    protected $fillable=[
        'user_id',
        'pharmacy_id',
    ];

    protected $hidden="";
    
    //admin with user
    public function user()
    {
        return $this->belongsTo(user::class,'user_id','id');
    }


    // //admin with pharamcy
    // public function pharmacy()
    // {
    //     return $this->belongsTo(pharmacy::class,'pharmacy_id','id');
    // }

    // //admin with orders[using the pharamcy_id fk]
    // public function order()
    // {
    //     return $this->hasMany(order::class,'pharmacy_id','pharmacy_id');
    // }

    // // Admin with order details through pharmacy
    // // just get the orderDetails for this pharmacy
    // public function orders_detalis()
    // {
    //     return $this->hasManyThrough(order_detalis::class, Order::class, 'pharmacy_id', 'order_id', 'pharmacy_id', 'id');
    // }
}
