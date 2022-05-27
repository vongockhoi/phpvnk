<?php

namespace App\Models;

use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;
use Rennokki\QueryCache\Traits\QueryCacheable;


class Media extends BaseMedia
{
    use QueryCacheable;

    public $table = 'media';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

}
