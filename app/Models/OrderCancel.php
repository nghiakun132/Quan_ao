<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCancel extends Model
{
    use HasFactory;

    protected $table = 'order_cancels';

    protected $fillable = [
        'order_id',
        'reason'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
