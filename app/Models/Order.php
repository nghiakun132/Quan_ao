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


    const LIST_STATUS = [
        self::PENDING => 'Chờ xác nhận',
        self::APPROVED => 'Đã xác nhận',
        self::DELIVERING => 'Đang giao hàng',
        self::DELIVERED => 'Đã giao hàng',
        self::CANCEL => 'Đã hủy',
    ];

    const STATUS_CLASS = [
        self::PENDING => 'warning',
        self::APPROVED => 'primary',
        self::DELIVERING => 'info',
        self::DELIVERED => 'success',
        self::CANCEL => 'danger',
    ];

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

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function orderAddress()
    {
        return $this->hasOne(OrderAddress::class, 'order_id', 'id');
    }

    public function getStatus()
    {
        return self::LIST_STATUS[$this->status];
    }

    public function getStatusClass()
    {
        return self::STATUS_CLASS[$this->status];
    }

    public function cancel()
    {
        return $this->hasOne(OrderCancel::class, 'order_id', 'id');
    }

    public function userDiscount()
    {
        return $this->hasOne(UserDiscount::class, 'order_id', 'id');
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class, 'coupon_code', 'code');
    }

    public static function getStatuses()
    {
        $statuses = new \stdClass();

        $statuses->{self::PENDING} = [
            self::APPROVED => 'Xác nhận đơn hàng',
            self::CANCEL => 'Hủy đơn hàng',
        ];

        $statuses->{self::APPROVED} = [
            self::DELIVERING => 'Đang giao hàng',
            self::CANCEL => 'Hủy đơn hàng',
        ];

        $statuses->{self::DELIVERING} = [
            self::DELIVERED => 'Đã giao hàng',
            self::CANCEL => 'Hủy đơn hàng',
        ];

        $statuses->{self::DELIVERED} = [
            self::CANCEL => 'Hủy',
        ];

        $statuses->{self::CANCEL} = [];



        return json_encode($statuses, true);
    }
}
