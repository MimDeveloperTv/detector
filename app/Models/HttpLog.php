<?php

namespace App\Models;

use App\Foundation\Concerns\HasCreatedAtScope;
use App\Foundation\Concerns\HasUlids;
use App\Foundation\Units\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HttpLog extends Model
{
    use HasFactory;
    use HasUlids;
    use HasCreatedAtScope;

    public const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'reference_id',
        'type',
        'supplier',
        'status',
        'url',
        'duration',
        'request',
        'response',
    ];
}
