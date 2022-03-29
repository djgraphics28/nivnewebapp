<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'or_number',
        'or_date',
        'description',
        'amount',
        'amount_word',
        'created_by',
        'updated_by',
        'salesman',
        'is_active',
        'customer_id',
        'branch_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(ReceiptProduct::class, 'receipt_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'salesman', 'id');
    }
}
