<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductIn extends Model
{
    use HasFactory;

    protected $fillable = ['qty','date_in', 'product_id', 'branch_id', 'supplier_id'];
}
