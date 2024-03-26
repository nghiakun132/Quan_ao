<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'percent',
        'start_at',
        'end_at',
        'quantity',
        'status',
        'description'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_discounts');
    }

    public function getDiscountHasUsedAttribute()
    {
        return $this->users()->count();
    }

    public function getStartAtAttribute()
    {
        return Carbon::parse($this->attributes['start_at'])->format('Y-m-d');
    }

    public function getEndAtAttribute($value)
    {
        return Carbon::parse($this->attributes['end_at'])->format('Y-m-d');
    }
}
