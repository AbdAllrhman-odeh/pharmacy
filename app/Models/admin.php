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
    
}
