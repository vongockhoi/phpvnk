<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CouponCustomer extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'coupon_customers';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'code',
        'coupon_id',
        'customer_id',
        'status_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function couponCustomerCarts()
    {
        return $this->hasMany(Cart::class, 'coupon_customer_id', 'id');
    }

    public function couponCustomerOrders()
    {
        return $this->hasMany(Order::class, 'coupon_customer_id', 'id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function status()
    {
        return $this->belongsTo(CouponCustomerStatus::class, 'status_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
