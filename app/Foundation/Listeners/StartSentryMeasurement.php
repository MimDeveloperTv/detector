<?php

namespace App\Foundation\Listeners;

use App\Foundation\Logging\Sentry\CustomInstrument;
use Illuminate\Http\Client\Events\RequestSending;

class StartSentryMeasurement
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
     * @param  RequestSending  $event
     * @return void
     */
    public function handle(RequestSending $event)
    {
        CustomInstrument::build()
            ->setOpName($event->request->toPsrRequest()->getUri()->getHost())
            ->setData([
                'http.url' => $event->request->url(),
            ])
            ->startSpan();
    }
}
