<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    use HasFactory;

    public $table = 'devices';

    protected $fillable = [
        'device_token',
        'device_name',
        'platform',
        'customer_id',
        'device_id',
        'user_id',
    ];

    const PLATFORM = array(
        'Android' => 1,
        'IOS'     => 2,
        'Web'     => 3,
    );

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
