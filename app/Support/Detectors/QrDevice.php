<?php

namespace App\Support\Detectors;

use App\Data\ProcessData;
use Illuminate\Support\Str;

class QrDevice extends Detectors
{
    public const NAME = 'QR_DEVICE';
    public const TYPE = 'URL';

    public function process(string $qrcode): ?ProcessData
    {
        $isUrl = filter_var($qrcode, FILTER_VALIDATE_URL);
        if ($isUrl && Str::contains($qrcode, 'https://idpay.ir/qrd/')) {
            return ProcessData::make(
                self::TYPE,
                self::NAME,
                [
                    'id' => (string) $this->extractEndUrl(2, $qrcode),
                    'url' => $qrcode,
                ]
            );
        } elseif (! $isUrl && Str::length($qrcode) == 7 && str_starts_with($qrcode, '3000')) {
            return ProcessData::make(
                self::TYPE,
                self::NAME,
                [
                    'id' => (string) $qrcode,
                    'url' => 'https://idpay.ir/qrd/'.$qrcode,
                ]
            );
        }

        return null;
    }
}
