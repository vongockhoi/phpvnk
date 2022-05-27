<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class OrderDetail extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'order_details';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'price_multiplication_quantity',
    ];

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'note',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getPriceMultiplicationQuantityAttribute()
    {
        $price = (float) ($this->product->price_discount ?? $this->product->price);
        $quantity = (float) $this->quantity;

        Log::info($price);
        Log::info($quantity);

        return (float) ($quantity * $price);
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
