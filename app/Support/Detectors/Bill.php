<?php

namespace App\Support\Detectors;

use App\Data\ProcessData;
use Illuminate\Support\Str;

class Bill extends Detectors
{
    public const NAME = 'BILL';
    public const TYPE = 'QR_CODE';

    public function process(string $qrcode): ?ProcessData
    {
        if (Str::length($qrcode) == 26 && is_numeric($qrcode)) {
            return ProcessData::make(
                self::TYPE,
                self::NAME,
                [
                    'bill_id' => Str::substr($qrcode, 0, 13),
                    'pay_id' => Str::substr($qrcode, 14, 26),
                ]
            );
        }

        return null;
    }
}
