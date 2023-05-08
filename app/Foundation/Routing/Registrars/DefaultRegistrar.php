<?php

namespace App\Foundation\Routing\Registrars;

use App\Foundation\Actions\HealthAction;
use App\Foundation\Routing\Contracts\RouteRegistrar;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Str;

class DefaultRegistrar implements RouteRegistrar
{
    public function map(Registrar $registrar): void
    {
        $registrar->get('health', HealthAction::class);

        $registrar->get('version', function () {
            return response()->json([
                'tag' => exec('git describe--tags--abbrev = 0'),
                'commit' => exec('git rev - parse--short HEAD'),
                'date' => exec('git show - s--format =%cI HEAD'),
                'service' => Str::slug(config('app . name'), ' - '),
            ]);
        });
    }
}
