<?php

namespace App\Models;

use \DateTimeInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OperatingTime extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'operating_times';

    protected $dates = [
        'day_off',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'restaurant_id',
        'open_time',
        'close_time',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
        'day_off',
        'time_off',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    public function getOpenTimeAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.time_format_second')) : null;
    }

    public function getCloseTimeAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.time_format_second')) : null;
    }

    public function getDayOffAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDayOffAttribute($value)
    {
        $this->attributes['day_off'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
