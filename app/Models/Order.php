<?php

namespace App\Models;

use App\Observers\OrderObserver;
use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'orders';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'code',
        'customer_id',
        'total_price',
        'address_id',
        'status_id',
        'reservation_id',
        'is_prepay',
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
        'deposit_amount',
    ];

    public static function boot()
    {
        parent::boot();
        self::observe(OrderObserver::class);
    }

    public function orderOrderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'status_id');
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }

    public function coupon_customer()
    {
        return $this->belongsTo(CouponCustomer::class, 'coupon_customer_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    public function rating()
    {
        return $this->hasOne(Rating::class, 'order_id', 'id');
    }
}
