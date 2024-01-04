<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cashier extends Model
{
    use HasFactory;

    public $table="cashiers";

    protected $fillable=[
        'user_id',
        'pharmacy_id',
    ];

    protected $hidden="";
}
