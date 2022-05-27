<?php

namespace App\Models;

use App\Constants\Globals\Cache as CacheConst;
use \DateTimeInterface;
use http\Client\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use stdClass;

class Banner extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use HasFactory;

    public const TYPE_SELECT = [
    ];

    public $table = 'banners';

    protected $appends = [
        'avatar',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'type',
        'description',
        'active',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $hidden = ['media'];

    public static function boot()
    {
        parent::boot();
        $key = CacheConst::KEY_NAME['HOME'];
        self::created(function () use ($key) {
            Cache::forget($key);
        });
        self::updated(function () use ($key) {
            Cache::forget($key);
        });
        self::deleted(function () use ($key) {
            Cache::forget($key);
        });
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
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
}
