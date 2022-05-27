<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductCategory extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use HasFactory;
    use QueryCacheable;

    public $table = 'product_categories';

    protected $appends = [
        'icon',
        'avatar',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'description',
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

    public function getIconAttribute()
    {
        $segments = request()->segments();
        $file = $this->getMedia('icon')->last();
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

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category', 'product_category_id', 'product_id');
    }
}
