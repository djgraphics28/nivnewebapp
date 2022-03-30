<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierProduct extends Model
{
    use HasFactory;

    protected $fillable = ['supplier_id', 'product_id', 'branch_id'];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
