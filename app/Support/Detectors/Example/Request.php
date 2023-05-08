<?php

namespace App\Support\Detectors\Example;

use App\Data\ProcessData;
use App\Support\Detectors\Detectors;
use Illuminate\Support\Str;

class Request extends Detectors
{
    public const NAME = 'REQUEST';
    public const TYPE = 'URL';

    public function process(string $qrcode): ?ProcessData
    {
        $isUrl = filter_var($qrcode, FILTER_VALIDATE_URL);
        if ($isUrl && Str::contains($qrcode, 'https://idpay.ir/q/')) {
            return ProcessData::make(
                self::TYPE,
                self::NAME,
                [
                    'id' => $this->extractEndUrl(2, $qrcode),
                    'url' => $qrcode,
                ]
            );
        } elseif (preg_match('/^[a-zA-Z0-9]{4,5}+$/', $qrcode)) {
            return ProcessData::make(
                self::TYPE,
                self::NAME,
                [
                    'id' => $qrcode,
                    'url' => 'https://idpay.ir/q/'.$qrcode,
                ]
            );
        }

        return null;
    }
}
