<?php

namespace App\Support\Detectors\Example;

use App\Data\ProcessData;
use App\Support\Detectors\Detectors;
use Illuminate\Support\Str;

class Plan extends Detectors
{
    public const NAME = 'PLAN';
    public const TYPE = 'URL';

    public function process(string $qrcode): ?ProcessData
    {
        $isUrl = filter_var($qrcode, FILTER_VALIDATE_URL);
        if ($isUrl && (Str::contains($qrcode, 'http://idpay.ir/') || Str::contains($qrcode, 'https://idpay.ir/'))) {
            $endQrCode = $this->extractEndUrl(2, $qrcode);
            if ($endQrCode == 'shop') {
                return ProcessData::make(
                    self::TYPE,
                    self::NAME,
                    [
                        'id' => $this->extractEndUrl(3, $qrcode) != null ? (string) $this->extractEndUrl(3, $qrcode) : null,
                        'gateway' => $this->extractEndUrl(1, $qrcode),
                        'url' => $qrcode,
                    ]
                );
            }
        }

        return null;
    }
}
