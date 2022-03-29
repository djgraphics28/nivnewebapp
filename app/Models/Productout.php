<?php

namespace App\Models;

use App\Models\ProductTracking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Productout extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tracking_number',
        'employee_id',
        'vehicle',
        'date_product_out',
        'status',
        'branch_id',
        'is_active',
    ];

    public function get_tracking_number()
    {
        return '#' . str_pad($this->id, 8, "0", STR_PAD_LEFT);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id', 'id');
    }

    public function product_tracking()
    {
        return $this->hasMany(ProductTracking::class, 'tracking_id', 'id');
    }

    // public function producttracking()
    // {
    //     return $this->hasManyThrough(
    //         Product::class,
    //         ProductTracking::class,
    //         'id',
    //         'id'
    //     );
    // }

    public function product()
    {
        return $this->belongsToMany(Product::class, 'product_trackings', 'product_id', 'tracking_id');
    }
}
