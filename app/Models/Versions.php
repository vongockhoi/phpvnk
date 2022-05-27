<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Versions extends Model
{
    use HasFactory;

    public $table = 'versions';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'platform',
        'version',
        'created_at',
        'updated_at',
    ];
}
