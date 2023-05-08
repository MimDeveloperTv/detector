<?php

namespace App\Foundation\Listeners;

use App\Foundation\Logging\Sentry\CustomInstrument;

class StopSentryMeasurement
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        CustomInstrument::getInstance()->finishSpan();
    }
}
