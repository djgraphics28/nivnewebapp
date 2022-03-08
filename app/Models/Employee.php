<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'lastname',
        'firstname',
        'middlename',
        'ename',
        'contact_number',
        'address',
        'position',
        'is_active',
        'branch_id',
    ];

    // public function stockreturn()
    // {
    //     return $this->belongsTo(Stockreturn::class);
    // }
}
