<?php

namespace App\Support\Detectors;

use App\Data\ProcessData;
use Illuminate\Support\Str;

class Taxi extends Detectors
{
    public const NAME = 'TAXI';
    public const TYPE = 'QR_CODE';

    public const MUNICIPALITIES = [
        //region TEHRAN
        'TEHRAN' => 'TEHRAN',
        '10' => 'TEHRAN',
        '1000' => 'TEHRAN',
        '1001' => 'TEHRAN',
        '1002' => 'TEHRAN',
        '1003' => 'TEHRAN',
        '1005' => 'TEHRAN',
        '1006' => 'TEHRAN',
        '1007' => 'TEHRAN',
        '1008' => 'TEHRAN',
        '1009' => 'TEHRAN',
        '1010' => 'TEHRAN',
        '1011' => 'TEHRAN',
        //endregion
        //region KARAJ
        'KARAJ' => 'KARAJ',
        '11' => 'KARAJ',
        '1100' => 'KARAJ',
        '1212' => 'KARAJ',
        '1213' => 'KARAJ',
        //endregion
        //region MASHHAD
        'MASHHAD' => 'MASHHAD',
        '2024' => 'MASHHAD',
        '2025' => 'MASHHAD',
        //endregion
        //region PEC
        '1115' => 'ISFAHAN',
        '1116' => 'ISFAHAN',
        '4049' => 'YAZD',
        '3947' => 'HAMEDAN',
        '3948' => 'HAMEDAN',
        '3846' => 'BANDARABBAS',
        '3745' => 'ARAK',
        '3643' => 'SARI',
        '3644' => 'SARI',
        '3542' => 'KHORRAMABAD',
        '3441' => 'RASHT',
        '3442' => 'RASHT',
        '3340' => 'GORGAN',
        '3751' => 'KISH',
        '3239' => 'YASUJ',
        '3138' => 'KERMANSHAH',
        '3037' => 'KERMAN',
        '2936' => 'SANANDAJ',
        '2835' => 'QOM',
        '2734' => 'QAZVIN',
        '2632' => 'SHIRAZ',
        '2633' => 'SHIRAZ',
        '2531' => 'ZAHEDAN',
        '2430' => 'SEMNAN',
        '2329' => 'ZANJAN',
        '2227' => 'AHVAZ',
        '2228' => 'AHVAZ',
        '2126' => 'BOJNURD',
        '1923' => 'BIRJAND',
        '1822' => 'SHAHRE_KORD',
        '2553' => 'CHAH_BAHAR',
        '1620' => 'BUSHEHR',
        '1819' => 'URMIA',
        '1418' => 'TABRIZ',
        '1317' => 'ILAM',
        '1721' => 'ARDABIL',
        '1757' => 'ARDABIL',
        //endregion
    ];

    public const SUPPLIERS = [
        //region TEHRAN
        'TEHRAN' => 'TEHRAN',
        '10' => 'TEHRAN',
        '1000' => 'TEHRAN',
        '1001' => 'PEC',
        '1002' => 'PEC',
        '1003' => 'PEC',
        '1005' => 'PEC',
        '1006' => 'PEC',
        '1007' => 'PEC',
        '1008' => 'PEC',
        '1009' => 'PEC',
        '1010' => 'PEC',
        '1011' => 'PEC',
        //endregion
        //region KARAJ
        'KARAJ' => 'FAASH',
        '11' => 'FAASH',
        '1100' => 'FAASH',
        '1212' => 'PEC',
        '1213' => 'PEC',
        //endregion
        //region MASHHAD
        'MASHHAD' => 'MASHHAD',
        '2024' => 'PEC',
        '2025' => 'PEC',
        //endregion
        //region PEC
        'PEC' => 'PEC',
        '1115' => 'PEC',
        '1116' => 'PEC',
        '4049' => 'PEC',
        '3947' => 'PEC',
        '3948' => 'PEC',
        '3846' => 'PEC',
        '3745' => 'PEC',
        '3643' => 'PEC',
        '3644' => 'PEC',
        '3542' => 'PEC',
        '3441' => 'PEC',
        '3442' => 'PEC',
        '3340' => 'PEC',
        '3751' => 'PEC',
        '3239' => 'PEC',
        '3138' => 'PEC',
        '3037' => 'PEC',
        '2936' => 'PEC',
        '2835' => 'PEC',
        '2734' => 'PEC',
        '2632' => 'PEC',
        '2633' => 'PEC',
        '2531' => 'PEC',
        '2430' => 'PEC',
        '2329' => 'PEC',
        '2227' => 'PEC',
        '2228' => 'PEC',
        '2126' => 'PEC',
        '1923' => 'PEC',
        '1822' => 'PEC',
        '2553' => 'PEC',
        '1620' => 'PEC',
        '1819' => 'PEC',
        '1418' => 'PEC',
        '1317' => 'PEC',
        '1721' => 'PEC',
        '1757' => 'PEC',
        //endregion
    ];

    public function process(string $qrcode): ?ProcessData
    {
        $isUrl = filter_var($qrcode, FILTER_VALIDATE_URL);
        if ($isUrl && Str::contains($qrcode, 'https://qr.top.ir/')) {
            parse_str(data_get(parse_url($qrcode), 'query'), $query);
            if (! Str::startsWith(data_get($query, 'qrcode'), '9')) {
                $qrcode = data_get($query, 'qrcode');
                if (! empty($this->getMunicipality($qrcode))) {
                    return ProcessData::make(
                        self::TYPE,
                        self::NAME,
                        [
                            'qr_code' => $qrcode,
                            'municipality' => $this->getMunicipality($qrcode),
                            'supplier' => $this->getSupplier('PEC'),
                        ]
                    );
                } else {
                    return null;
                }
            }
        } elseif ($isUrl && Str::contains($qrcode, 'https://wallet.mashhad.ir/')) {
            return ProcessData::make(
                self::TYPE,
                self::NAME,
                [
                    'qr_code' => $this->extractEndUrl(2, $qrcode),
                    'municipality' => $this->getMunicipality('MASHHAD'),
                    'supplier' => $this->getSupplier('MASHHAD'),
                ]
            );
        } elseif (Str::contains($qrcode, 'wallet.mashhad.ir')) {
            return ProcessData::make(
                self::TYPE,
                self::NAME,
                [
                    'qr_code' => Str::substr($qrcode, Str::length('wallet.mashhad.ir'), 11),
                    'municipality' => $this->getMunicipality('MASHHAD'),
                    'supplier' => $this->getSupplier('MASHHAD'),
                ]
            );
        } elseif ($isUrl && Str::contains($qrcode, 'https://shahrpayservices.tehran.ir/pay/taxi')) {
            parse_str(data_get(parse_url($qrcode), 'query'), $query);
            $provinceCode = data_get($query, 'i');
            $qrcode = $provinceCode.data_get($query, 't');

            return ProcessData::make(
                self::TYPE,
                self::NAME,
                [
                    'qr_code' => $qrcode,
                    'municipality' => $this->getMunicipality($qrcode, 2),
                    'supplier' => $this->getSupplier('TEHRAN'),
                ]
            );
        } elseif (Str::contains($qrcode, 'rapsa://pay')) {
            parse_str(Str::remove('rapsa://pay?', $qrcode, false), $query);
            $provinceCode = data_get($query, 'i');
            $qrcode = $provinceCode.data_get($query, 't');

            return ProcessData::make(
                self::TYPE,
                self::NAME,
                [
                    'qr_code' => $qrcode,
                    'municipality' => $this->getMunicipality($qrcode, 2),
                    'supplier' => $this->getSupplier($qrcode, 2),
                ]
            );
        } elseif (is_numeric($qrcode) && Str::length($qrcode) == 11) {
            return ProcessData::make(
                self::TYPE,
                self::NAME,
                [
                    'qr_code' => $qrcode,
                    'municipality' => $this->getMunicipality('MASHHAD'),
                    'supplier' => $this->getSupplier('MASHHAD'),
                ]
            );
        } elseif (is_numeric($qrcode) && Str::length($qrcode) == 10 && ! Str::startsWith($qrcode, '9')) {
            if (! empty($this->getMunicipality($qrcode))) {
                return ProcessData::make(
                    self::TYPE,
                    self::NAME,
                    [
                        'qr_code' => $qrcode,
                        'municipality' => $this->getMunicipality($qrcode),
                        'supplier' => $this->getSupplier($qrcode),
                    ]
                );
            } elseif (! empty($this->getMunicipality($qrcode, 2))) {
                return ProcessData::make(
                    self::TYPE,
                    self::NAME,
                    [
                        'qr_code' => $qrcode,
                        'municipality' => $this->getMunicipality($qrcode, 2),
                        'supplier' => $this->getSupplier($qrcode, 2),
                    ]
                );
            } else {
                return null;
            }
        }

        return null;
    }

    public function getMunicipality(string $qrcode, int $numbers = 4)
    {
        return is_numeric($qrcode) ? self::MUNICIPALITIES[Str::substr($qrcode, 0, $numbers)] ?? null : self::MUNICIPALITIES[$qrcode];
    }

    public function getSupplier(string $qrcode, int $numbers = 4)
    {
        return is_numeric($qrcode) ? self::SUPPLIERS[Str::substr($qrcode, 0, $numbers)] ?? null : self::SUPPLIERS[$qrcode];
    }
}
