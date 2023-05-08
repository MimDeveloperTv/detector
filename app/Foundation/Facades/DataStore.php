<?php

namespace App\Foundation\Facades;

use App\Foundation\Stores\ContainerStore;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void add(string $key, mixed $value)
 * @method static Collection|null get(string $key)
 * @method static array all()
 * @method static void remove(string $key)
 * @method static void purge()
 *
 * @see \App\Foundation\Stores\ContainerStore
 */
class DataStore extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ContainerStore::class;
    }
}
