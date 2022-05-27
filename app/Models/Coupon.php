<?php

namespace App\Models;

use \DateTimeInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Coupon extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use HasFactory;

    public $table = 'coupons';

    public static $searchable = [
        'name',
    ];

    protected $appends = [
        'avatar',
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'code',
        'name',
        'description',
        'value',
        'discount_type_id',
        'start_date',
        'end_date',
        'coupon_type_id',
        'status_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $hidden = ['media'];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function couponCouponCustomers()
    {
        return $this->hasMany(CouponCustomer::class, 'coupon_id', 'id');
    }

    public function getAvatarAttribute()
    {
        $segments = request()->segments();
        $file = $this->getMedia('avatar')->last();
        if ($file && in_array('api', $segments)) {
            return [
                'url' => $file->getUrl() ?? null,
                'thumbnail' => $file->getUrl('thumb') ?? null,
                'preview' => $file->getUrl('preview') ?? null,
            ];
        }
        if ($file) {
            $file->url = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview = $file->getUrl('preview');
        }

        return $file;
    }

    public function discount_type()
    {
        return $this->belongsTo(DiscountType::class, 'discount_type_id');
    }

    public function getStartDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getEndDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class);
    }

    public function coupon_type()
    {
        return $this->belongsTo(CouponType::class, 'coupon_type_id');
    }

    public function status()
    {
        return $this->belongsTo(CouponStatus::class, 'status_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
