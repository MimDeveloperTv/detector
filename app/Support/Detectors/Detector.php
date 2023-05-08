<?php

namespace App\Support\Detectors;

use App\Data\ProcessData;

interface Detector
{
    public function process(string $qrcode): ?ProcessData;
}
