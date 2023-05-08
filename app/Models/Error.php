<?php

namespace App\Models;

use App\Foundation\Concerns\HasCreatedAtScope;
use App\Foundation\Concerns\HasUlids;
use App\Foundation\Units\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Error extends Model
{
    use HasFactory;
    use HasUlids;
    use HasCreatedAtScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'supplier',
        'code',
        'status',
        'count',
        'encoded_message',
        'message',
    ];
}
