<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhilippineCity extends Model
{
    use HasFactory;

    protected $fillable = [
        'psgc_code',
        'city_municipality_description',
        'region_description',
        'province_code',
        'city_municipality_code',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'city_municipality_code', 'city_municipality_code');
    }
}
