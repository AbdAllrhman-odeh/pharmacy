<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class medicine_transfer_details extends Model
{
    use HasFactory;

    public $table="medicines_tranfers_detalis";
    
    protected $fillable=[
        'medicine_transfer_id',
        'medicine_id',
        'source_pharmacy_id',
        'destination_pharmacy_id',
        'quantity'
    ];

    protected $hidden="";
}
