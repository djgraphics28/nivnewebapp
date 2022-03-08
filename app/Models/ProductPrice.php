<?php

namespace App\Models;

// use App\Models\Stock;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductPrice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'price_per_case',
        'price_per_pcs',
        'date_valid',
        'is_active',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'priduct_id', 'id');
    }

    // public function stock()
    // {
    //     return $this->belongsTo(Stock::class);
    // }


}
