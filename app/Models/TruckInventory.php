<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TruckInventory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tracking_number',
        'employee_id',
        'branch_id',
        'vehicle',
        'date_load',
        'created_by',
        'updated_by',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(TruckItem::class, 'tracking_id', 'id');
    }

    public function tracking_dates()
    {
        return $this->hasMany(TrackingDate::class, 'tracking_id', 'id');
    }
}
