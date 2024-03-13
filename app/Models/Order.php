<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const PENDING = 0;
    const APPROVED = 1;
    const DELIVERING = 2;
    const DELIVERED = 3;
    const CANCEL = 4;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'code',
        'discount',
        'shipping_fee',
        'total',
        'coupon_code',
        'status',
        'note'
    ];

    public function details(){
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }
}
