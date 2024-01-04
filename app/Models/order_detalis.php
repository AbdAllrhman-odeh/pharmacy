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
    ];

    protected $hidden="";
}
