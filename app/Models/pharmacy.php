<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pharmacy extends Model
{
    use HasFactory;

    public $table="pharmacies";
    protected $fillable=[
        'name',
        'location',
        'number',
    ];
    protected $hidden=[];
}
