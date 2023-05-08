<?php

namespace App\Providers;

use App\Foundation\Listeners\StartSentryMeasurement;
use App\Foundation\Listeners\StopSentryMeasurement;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Http\Client\Events\ConnectionFailed;
use Illuminate\Http\Client\Events\RequestSending;
use Illuminate\Http\Client\Events\ResponseReceived;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        RequestSending::class => [
            StartSentryMeasurement::class,
        ],
        ResponseReceived::class => [
            StopSentryMeasurement::class,
        ],
        ConnectionFailed::class => [
            StopSentryMeasurement::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
