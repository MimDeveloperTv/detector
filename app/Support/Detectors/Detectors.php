<?php

namespace App\Support\Detectors;

use App\Support\Detectors\UniqueHashtag;

abstract class Detectors implements Detector
{
    public const NAME = 'DETECTORS';
    public const TYPE = '';

    public const SERVICES = [
        UniqueHashtag::class,
    ];

    public static function make(string $service): Detector
    {
        return app($service);
    }
}
