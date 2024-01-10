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

    public function user()
    {
        return $this->belongsTo(user::class,'user_id','id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'cashier_id', 'id');
    }
}
