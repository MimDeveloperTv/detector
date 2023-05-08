<?php

namespace App\Models;

use App\Foundation\Units\Model;

class FailedJob extends Model
{
    public $timestamps = false;

    protected $casts = [
        'payload' => 'json',
        'failed_at' => 'datetime',
    ];
}
