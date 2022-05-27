<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'messages';

    protected $fillable = [
        'title',
        'sub_title',
        'content',
        'target_type',
        'target_id',
        'app_notification',
        'app_notification_at',
        'last_read_at',
        'customer_id',
        'status',
        'created_by_id',
    ];

    const TARGET_TYPE = [
        '1' => 'Tặng coupon',
        '2' => 'Thông thường',
        '3' => 'Thông báo thay đổi trạng thái đơn hàng',
    ];
}
