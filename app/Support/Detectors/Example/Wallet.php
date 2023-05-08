<?php

namespace App\Support\Detectors\Example;

use App\Data\ProcessData;
use App\Support\Detectors\Detectors;
use Illuminate\Support\Str;

class Wallet extends Detectors
{
    public const NAME = 'WALLET';
    public const TYPE = 'QR_CODE';

    public function process(string $qrcode): ?ProcessData
    {
        if (Str::is('idpay://wallet/*', $qrcode)) {
            return ProcessData::make(
                self::TYPE,
                self::NAME,
                [
                    'id' => (string) explode('/', $qrcode)[3],
                ]
            );
        }

        return null;
    }
}
