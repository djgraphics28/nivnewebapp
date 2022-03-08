<?php

namespace App\Models;

use App\Models\Branch;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'stocks';

    protected $fillable = [
        'stock_code',
        'qty',
        'classi',
        'product_id',
        'supplier_id',
        'product_id',
        'branch_id',
        'status',
        'expr_date',
        'date_delivered',
        'price',
        'price_per_pcs',
        'selling_price',
        'selling_per_pcs',
        'created_by',
        'updated_by',
        'classification',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }



    public function scopeSearch($query, $searchTerm)
    {
        $searchTerm = "%$searchTerm%";

        $query->where(function($query) use ($searchTerm){
            $query->where('stock_code','like', $searchTerm)
            ->orWhere('product_id','like', $searchTerm);
        });


    }



}
