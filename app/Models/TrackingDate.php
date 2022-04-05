<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrackingDate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['tracking_id', 'date_load', 'date_return', 'is_active'];
}
