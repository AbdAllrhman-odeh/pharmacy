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
        'chemical_name',
        'does',
        'type',
        'quantity',
        'price',
        'exp_date',
        'mfg-date',
        'pharamcy_id',
        'company_name',
    ];

    protected $hidden="";
}
