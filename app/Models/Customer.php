<?php

namespace App\Models;

use \DateTimeInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Customer extends Authenticatable implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use HasFactory;
    use HasApiTokens;

    public $table = 'customers';

    public static $searchable = [
        'full_name',
        'birthday',
        'phone',
        'email',
    ];

    protected $appends = [
        'avatar',
    ];

    protected $hidden = [
        'password',
    ];

    protected $dates = [
        'birthday',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'full_name',
        'first_name',
        'last_name',
        'birthday',
        'phone',
        'email',
        'password',
        'membership_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'verified',
        'verified_at',
        'is_develop',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getIsDevelopAttribute($value)
    {
        return boolval($value ?? 0);
    }

    public function customerCarts()
    {
        return $this->hasMany(Cart::class, 'customer_id', 'id');
    }

    public function customerOrders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'id');
    }

    public function customerReservations()
    {
        return $this->hasMany(Reservation::class, 'customer_id', 'id');
    }

    public function customerAddresses()
    {
        return $this->hasMany(Address::class, 'customer_id', 'id');
    }

    public function customerCouponCustomers()
    {
        return $this->hasMany(CouponCustomer::class, 'customer_id', 'id');
    }

    public function getAvatarAttribute()
    {
        $file = $this->getMedia('avatar')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function getBirthdayAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function myPoints()
    {
        return $this->hasOne(Point::class, 'customer_id');
    }

    public function push_devices()
    {
        return $this->hasMany(Device::class, 'customer_id');
    }
}
