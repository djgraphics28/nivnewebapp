<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TruckLoading extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tracking_number',
        'employee_id',
        'vehicle',
        'date_of_load',
        'date_of_unload',
        'branch_id',
        'is_active',
    ];

}
