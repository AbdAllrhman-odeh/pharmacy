<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class superAdminModel extends Model
{
    use HasFactory;

    public $table="super_admin";

    protected $fillable=['user_id','pharmacy_id'];

    protected $hidden=[];

    public $timestamps=false;

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function pharmacies() {
        return $this->hasMany(Pharmacy::class, 'id', 'pharmacy_id');
    }
    
}
