<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class alternative_medicine extends Model
{
    use HasFactory;

    public $table="alternative_medicines";

    protected $fillable=[
        'id','original_medicine_id','alternative_medicine_id','pharmacy_id'
    ];
    protected $hidden=[];

    public function originalMedicine()
    {
        return $this->belongsTo(Medicine::class, 'original_medicine_id');
    }

    public function alternativeMedicine()
    {
        return $this->belongsTo(Medicine::class, 'alternative_medicine_id');
    }

    // // Define the relationship for the alternative medicine
    // public function alternativeMedicine()
    // {
    //     return $this->belongsTo(Medicine::class, 'alternative_medicine_id');
    // }

}
