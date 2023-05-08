<?php

namespace App\Support\Detectors;

use App\Data\ProcessData;
use Illuminate\Support\Str;

class Gateway extends Detectors
{
    public const NAME = 'GATEWAY';
    public const TYPE = 'URL';

    public function process(string $qrcode): ?ProcessData
    {
        $isUrl = filter_var($qrcode, FILTER_VALIDATE_URL);
        if ($isUrl && (Str::contains($qrcode, 'http://idpay.ir/') || Str::contains($qrcode, 'https://idpay.ir/'))) {
            $endQrCode = $this->extractEndUrl(2, $qrcode);
            if (is_null($endQrCode)) {
                return ProcessData::make(
                    self::TYPE,
                    self::NAME,
                    [
                        'gateway' => $this->extractEndUrl(1, $qrcode),
                        'url' => $qrcode,
                    ]
                );
            }
        }

        return null;
    }
}
