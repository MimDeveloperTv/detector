<?php

namespace App\Support\Detectors;

abstract class Detectors implements Detector
{
    public const NAME = 'DETECTORS';
    public const TYPE = '';

    public const SERVICES = [
        File::class,
        Gateway::class,
        Plan::class,
        QrDevice::class,
        QrGateway::class,
        Request::class,
        Wallet::class,
        Campaign::class,
        Bill::class,
        Taxi::class,
        CoMerchant::class,
    ];

    public static function make(string $service): Detector
    {
        return app($service);
    }

    protected function extractEndUrl(int $index, string $qrCode): ?string
    {
        return explode('/', parse_url($qrCode)['path'])[$index] ?? null;
    }
}
