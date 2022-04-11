<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhilippineProvince extends Model
{
    use HasFactory;

    protected $fillable = [
        'psgc_code',
        'province_description',
        'region_code',
        'province_code',
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class, 'province_code', 'province_code');
    }
}
