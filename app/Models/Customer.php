<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_name',
        'address',
        'contact_number',
        'channel',
        'is_active',
        'email',
        'branch_id',
        'city_municipality_code',
        'province_code',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function receipt()
    {
        return $this->hasOne(Receipt::class, 'customer_id', 'id');
    }

    public function scopeSearch($query, $searchTerm)
    {
        $searchTerm = "%$searchTerm%";

        $query->where(function($query) use ($searchTerm){

            $query->where('customer_name','like', $searchTerm);
        });


    }

    public function city()
    {
        return $this->belongsTo(PhilippineCity::class, 'city_municipality_code', 'city_municipality_code');
    }

    public function province()
    {
        return $this->belongsTo(PhilippineProvince::class, 'province_code', 'province_code');
    }
}
