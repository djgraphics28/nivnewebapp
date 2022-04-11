<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhilippineBarangay extends Model
{
    use HasFactory;

    protected $fillable = [
        'barangay_code',
        'barangay_description',
        'region_code',
        'province_code',
        'city_municipality_code',
    ];


}
