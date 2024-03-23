<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    use HasFactory;

    protected $table = 'order_addresses';

    protected $fillable = [
        'order_id',
        'name',
        'phone',
        'address',
        'province',
        'district',
        'ward',
    ];

    public function provinces()
    {
        return $this->belongsTo(Province::class, 'province', 'id');
    }

    public function districts()
    {
        return $this->belongsTo(District::class, 'district', 'id');
    }

    public function wards()
    {
        return $this->belongsTo(Ward::class, 'ward', 'id');
    }

    public function getOrderAddressAttribute()
    {
        $address = '';

        if (!empty ($this->address)) {
            $address .= $this->address . ', ';
        }

        if (!empty ($this->wards)) {
            $address .= $this->wards->name . ', ';
        }

        if (!empty ($this->districts)) {
            $address .= $this->districts->name . ', ';
        }

        if (!empty ($this->provinces)) {
            $address .= $this->provinces->name;
        }

        return $address;

    }
}
