<?php

namespace App\Foundation\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

trait HasCreatedAtScope
{
    /**
     * @param  Builder  $query
     * @param $date
     * @return Builder
     */
    public function scopeCreatedBefore(Builder $query, $date): Builder
    {
        return $query->where('created_at', '<=', Carbon::parse($date));
    }

    /**
     * @param  Builder  $query
     * @param $date
     * @return Builder
     */
    public function scopeCreatedAfter(Builder $query, $date): Builder
    {
        return $query->where('created_at', '>=', Carbon::parse($date));
    }
}
