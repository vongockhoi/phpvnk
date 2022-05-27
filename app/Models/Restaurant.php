<?php

namespace App\Models;

use App\Constants\Globals\Cache as CacheConst;
use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Restaurant extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use HasFactory;
    use QueryCacheable;

    public $table = 'restaurants';

    protected $appends = [
        'avatar',
        'featured_image',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'province_id',
        'district_id',
        'address',
        'status_id',
        'latitude',
        'longitude',
        'description',
        'hotline',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $hidden = ['media'];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Artisan::call('cache:clear');
        });
        self::updated(function ($model) {
            Artisan::call('cache:clear');
        });
        self::deleted(function ($model) {
            Artisan::call('cache:clear');
        });
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function restaurantRestaurantShippingFees()
    {
        return $this->hasMany(RestaurantShippingFee::class, 'restaurant_id', 'id');
    }

    public function cartDetail()
    {
        return $this->hasMany(CartDetail::class, 'restaurant_id', 'id');
    }

    public function restaurantOperatingTimes()
    {
        return $this->hasOne(OperatingTime::class, 'restaurant_id', 'id')->orderBy("id", "desc");
    }

    public function restaurantProducts()
    {
        return $this->belongsToMany(Product::class);
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

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function status()
    {
        return $this->belongsTo(RestaurantStatus::class, 'status_id');
    }

    public function getFeaturedImageAttribute()
    {
        $segments = request()->segments();
        $files = $this->getMedia('featured_image');
        if (!empty($files) && in_array('api', $segments)) {
            $result = [];
            foreach ($files as $item) {
                $_result = [
                    'url' => $item->getUrl() ?? null,
                    'thumbnail' => $item->getUrl('thumb') ?? null,
                    'preview' => $item->getUrl('preview') ?? null,
                ];
                $result[] = $_result;
            }
            return $result;
        }

        $files->each(function ($item) {
            $item->url = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview = $item->getUrl('preview');
        });

        return $files;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
