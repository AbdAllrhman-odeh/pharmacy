<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class medicine_transfer extends Model
{
    use HasFactory;

    public $table="medicines_transfer";

    protected $fillable=[
        'admin_id'
    ];

    protected $hidden="";
}
