<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TruckItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'tracking_id',
        'type',
        'tracking_date_id',
        'load_quantity',
        'date_return',
        'return_quantity',
        'return_unit',
        'return_pcs',
    ];

    public function products()
    {
    	return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function product()
    {
    	return $this->hasOne(Product::class, 'product_id', 'id');
    }

    // public function activePrice()
    // {
    //     return $this->hasOneThrough(
    //         Product::class,
    //         PriceTbl::class,
    //         'product_id', // Foreign key on the cars table...
    //         'car_id', // Foreign key on the owners table...
    //         'id', // Local key on the mechanics table...
    //         'id' // Local key on the cars table...
    //     );
    // }
}
