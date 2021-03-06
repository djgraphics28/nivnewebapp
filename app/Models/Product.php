<?php

namespace App\Models;

use App\Models\ProductPrice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_name',
        'sku',
        'description',
        'branch_id',
        'unit',
        'category_id',
        'brand_id',
        'image_url',
        'stockalert',
        'stocks',
    ];

    // protected $appends = ['stock_num'];

    // public function getStock_numAttribute() {
    //     return $this->stock->qty;

    // }

    public function stock()
    {
        return $this->hasMany(Stock::class, 'product_id', 'id');
    }

    public function tracking()
    {
        return $this->hasMany(ProductTracking::class, 'product_id', 'id');
    }

    public function price()
    {
        return $this->hasMany(ProductPrice::class, 'product_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function productout()
    {
        return $this->belongsToMany(Productout::class, 'product_trackings', 'tracking_id', 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function receipt_product()
    {
        return $this->belongsTo(ReceiptProduct::class, 'product_id', 'id');
    }

    public function supplier_products()
    {
        return $this->hasManyThrough(SupplierProduct::class, 'product_id', 'id');
    }

    public function scopeSearch($query, $searchTerm)
    {
        $searchTerm = "%$searchTerm%";

        $query->where(function($query) use ($searchTerm){

            $query->where('product_name','like', $searchTerm)
            ->orWhere('sku','like', $searchTerm);
        });


    }

    public function activePrice()
    {
       return  $this->hasOne(PriceTbl::class)->latest();
    }

    // public function getImageUrlAttribute()
    // {
    //     if($this->image_url){
    //         retrun Storage::disk('photo')->url($this-avatar);
    //     }

    //     return asset('noimage.png');
    // }

    public function supppliers()
    {
        return $this->belongsToMany(Supplier::class, 'supplier_products', 'product_id', 'supplier_id');
    }

}
