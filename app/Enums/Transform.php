<?php

namespace App\Enums;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;

class Transform
{
    /**
     * @param  string  $value
     * @return array
     */
    public static function formatter(string $value): array
    {
        return [
            'id' => $value,
            'title' => Lang::has('enums.'.$value) ? __('enums.'.$value) : __($value),
        ];
    }

    /**
     * @param  array  $enums
     * @return Collection
     */
    public static function mapper(array $enums): Collection
    {
        return collect($enums)->map(fn ($value) => self::formatter($value));
    }
}
