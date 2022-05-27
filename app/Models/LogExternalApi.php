<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogExternalApi extends Model
{
    use HasFactory;

    public $table = 'log_external_api';

    const FIELD_REQUEST_AT = 'request_at';
    const FIELD_REQUEST = 'request';
    const FIELD_RESPONSE = 'response';
    const FIELD_PROVIDER = 'provider';

    protected $fillable = [
        self::FIELD_REQUEST_AT,
        self::FIELD_REQUEST,
        self::FIELD_RESPONSE,
        self::FIELD_PROVIDER,
    ];
}
