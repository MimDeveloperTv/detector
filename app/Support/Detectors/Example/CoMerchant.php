<?php

namespace App\Support\Detectors\Example;

use App\Data\ProcessData;
use App\Support\Detectors\Detectors;
use Illuminate\Support\Str;
use function data_get;

class CoMerchant extends Detectors
{
    public const NAME = 'CO_MERCHANT';
    public const TYPE = 'QR_CODE';
    public const CODES = '9';

    public const MERCHANTS = [
        'TOP' => 'PEC',
        'PEC' => 'PEC',
        '724' => '724.ir',
        'SEKEH' => 'SEKEH',
    ];

    public function process(string $qrcode): ?ProcessData
    {
        $isUrl = filter_var($qrcode, FILTER_VALIDATE_URL);
        parse_str(data_get(parse_url($qrcode), 'query'), $query);
        if ($isUrl && Str::contains($qrcode, 'https://qr.top.ir/') &&
            Str::startsWith(data_get($query, 'qrcode'), '9')) {
            return ProcessData::make(
                self::TYPE,
                self::NAME,
                [
                    'merchant_name' => self::MERCHANTS['TOP'],
                    'merchant_url' => $qrcode,
                ]
            );
        } elseif (Str::contains($qrcode, '724.ir')) {
            return ProcessData::make(
                self::TYPE,
                self::NAME,
                [
                    'merchant_name' => self::MERCHANTS['724'],
                    'merchant_url' => $qrcode,
                ]
            );
        } elseif (Str::contains($qrcode, 'SEKEH,5')) {
            return ProcessData::make(
                self::TYPE,
                self::NAME,
                [
                    'merchant_name' => self::MERCHANTS['SEKEH'],
                    'merchant_url' => $qrcode,
                ]
            );
        } elseif (is_numeric($qrcode) && Str::length($qrcode) == 10 && Str::startsWith($qrcode, self::CODES)) {
            return ProcessData::make(
                self::TYPE,
                self::NAME,
                [
                    'merchant_name' => self::MERCHANTS['TOP'],
                    'merchant_url' => "https://qr.top.ir/?qrcode={$qrcode}",
                ]
            );
        }

        return null;
    }
}
