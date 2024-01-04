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
}
