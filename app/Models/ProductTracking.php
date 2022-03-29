<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_id',
        'product_id',
        'qty',
        'type',
        'return_qty',
        'pieces_qty',
        'return_unit',
        'date_return',
        'price_per_case',
        'price_per_pcs',
        'created_by',
        'updated_by',
        'status',
        'customer_id',
        'branch_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function productout()
    {
        return $this->belongsTo(Productout::class, 'tracking_id', 'id');
    }

    public function product_brand()
    {
        return $this->hasManyThrough(Product::class, Brand::class, );
    }
}
