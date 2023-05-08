<?php

namespace App\Support\Detectors;

use App\Data\ProcessData;
use Illuminate\Support\Str;

class Campaign extends Detectors
{
    public const NAME = 'CAMPAIGN';
    public const TYPE = 'URL';

    public function process(string $qrcode): ?ProcessData
    {
        $isUrl = filter_var($qrcode, FILTER_VALIDATE_URL);

        if ($isUrl && (Str::contains($qrcode, 'http://idpay.ir/') || Str::contains($qrcode, 'https://idpay.ir/'))) {
            $endQrCode = $this->extractEndUrl(2, $qrcode);
            if ($endQrCode == 'campaign' || $endQrCode == 'camp') {
                return ProcessData::make(
                    self::TYPE,
                    self::NAME,
                    [
                        'id' => $endQrCode == 'camp' ? (string) $this->extractEndUrl(3, $qrcode) : null,
                        'gateway' => $this->extractEndUrl(1, $qrcode),
                        'url' => $qrcode,
                    ]
                );
            }
        }

        return null;
    }
}
