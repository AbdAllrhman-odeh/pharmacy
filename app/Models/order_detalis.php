<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_detalis extends Model
{
    use HasFactory;

    public $table="orders_detalis";

    protected $fillable=[
        'order_id',
        'medicine_id',
        'quantity',
        'cashier_id'
    ];

    protected $hidden="";

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function cashier()
    {
        return $this->belongsTo(Cashier::class, 'cashier_id', 'id');
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id', 'id');
    }
}
