<?php

namespace App\Support\Detectors;

use App\Data\ProcessData;
use Illuminate\Support\Str;

class UniqueHashtag extends Detectors
{
    public const NAME = 'UniqueHashtag';

    public function process(string $input)
    {

        $inputToArray = explode('.', $input);
        $safeInputArray = self::prepareValidInputData($inputToArray);
        $uniqueInputArray = array_unique($safeInputArray);

        $counter = 1;
        $counterArray = [];
        foreach ($uniqueInputArray as $item){
            $counterArray[] = "{$counter}- {$item}";
            $counter++;
        }
        $prepareListNumeric = implode(PHP_EOL,$counterArray);
        $prepareListHashtags = implode('.',$uniqueInputArray);
        return response()->json([
            'ListNumeric' => $prepareListNumeric,
            'ListHashtags' => $prepareListHashtags
        ]);
    }
}
