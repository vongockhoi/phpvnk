<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Artisan;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use HasFactory;
    use QueryCacheable;

    public $table = 'products';

    public static $searchable = [
        'name',
    ];

    protected $appends = [
        'price_text',
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
        'category_id',
        'price',
        'price_discount',
        'quantity',
        'status_id',
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
        'is_price_change',
        'type',
        'preparation_time',
        'brief_description',
        'product_unit_id',
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
        if ($media->collection_name == 'avatar') {
            $this->addMediaConversion('preview')->fit('crop', 400, 400);
        } else {
            $this->addMediaConversion('preview')->fit('crop', 120, 120);
        }
    }

    public function getPriceTextAttribute()
    {
        $price = $this->price;
        return numberToWord((int)$price);
    }

    public function getIsPriceChangeAttribute($value)
    {
        return boolval($value ?? 0);
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

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class, 'product_category', 'product_id', 'product_category_id');
    }

    public function status()
    {
        return $this->belongsTo(ProductStatus::class, 'status_id');
    }

    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class);
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

    public function hash_tags()
    {
        return $this->belongsToMany(HashTag::class);
    }

    public function product_unit()
    {
        return $this->belongsTo(ProductUnit::class, 'product_unit_id');
    }
}
