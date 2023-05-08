<?php

namespace App\Foundation\Facades;

use App\Foundation\Transporter\Request;
use Illuminate\Support\Facades\Facade;

/**
 * Class Pool
 *
 * @method static \App\Foundation\Transporter\Concurrently build()
 * @method static \App\Foundation\Transporter\Concurrently fake()
 * @method static \App\Foundation\Transporter\Concurrently setRequests(Request[] $requests)
 * @method static \App\Foundation\Transporter\Concurrently add(Request $request)
 * @method static \Illuminate\Support\Collection run()
 */
class Concurrently extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \App\Foundation\Transporter\Concurrently::class;
    }
}
