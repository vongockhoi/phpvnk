<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory;

    public $table = 'carts';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'customer_id',
        'total_price',
        'address_id',
        'coupon_customer_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'restaurant_id',
        'is_delivery',
        'price_original',
        'discount_coupon',
        'discount_membership',
        'price_ship',
    ];

    public function cartCartDetails()
    {
        return $this->hasMany(CartDetail::class, 'cart_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function coupon_customer()
    {
        return $this->belongsTo(CouponCustomer::class, 'coupon_customer_id');
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
