<?php

namespace App\Models;

use App\Models\SupplierProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'supplier_name',
        'email',
        'contact_number',
        'address',
        'is_active',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'supplier_products', 'supplier_id', 'product_id');
    }
}
