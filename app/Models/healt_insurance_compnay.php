<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class healt_insurance_compnay extends Model
{
    use HasFactory;

    public $table="health_insurance_companies";
    
    protected $fillable=[
        'name'
    ];

    protected $hidden="";
}
