<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
        'is_default',
        'province',
        'district',
        'ward',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward');
    }

    public function getFullAddressAttribute()
    {
        return $this->address . ', ' . $this->ward()->first()->name . ', ' . $this->district()->first()->name . ', ' . $this->province()->first()->name;
    }
}
