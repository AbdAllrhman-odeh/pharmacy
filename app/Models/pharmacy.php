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

        //pharmacy with admins
        public function admins()
        {
            return $this->hasMany(admin::class,'pharmacy_id','id');
        }


        public function orders()
        {
            return $this->hasMany(Order::class,'order_id','id');
        }
    
}
