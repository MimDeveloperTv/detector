<?php

namespace App\Foundation\Routing\Concerns;

use App\Foundation\Routing\Contracts\RouteRegistrar;
use Illuminate\Contracts\Routing\Registrar;
use RuntimeException;

trait MapsRouteRegistrars
{
    protected function mapRoutes(Registrar $router, array $registrars): void
    {
        foreach ($registrars as $registrar) {
            if (! class_exists($registrar) || ! is_subclass_of($registrar, RouteRegistrar::class)) {
                throw new RuntimeException(sprintf(
                    'Cannot map routes \'%s\', it is not a valid routes class',
                    $registrar
                ));
            }

            (new $registrar)->map($router);
        }
    }
}
