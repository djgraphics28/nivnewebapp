<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_id',
        'product_id',
        'qty',
        'amount',
    ];

    public function product()
    {
    	return $this->belongsTo(Product::class, 'product_id', 'id');
    }


}
