<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceTbl extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'price_per_case', 'price_per_pcs', 'is_active','date_priced',];

    public function product()
    {
       return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
