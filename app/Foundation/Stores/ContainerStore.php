<?php

namespace App\Foundation\Stores;

use Illuminate\Support\Collection;

class ContainerStore
{
    private array $states = [];

    public function add(string $key, mixed $value): void
    {
        data_set($this->states, $key, collect($value));
    }

    public function get(string $key): ?Collection
    {
        return data_get($this->states, $key);
    }

    public function all(): array
    {
        return $this->states;
    }

    public function remove(string $key): void
    {
        unset($this->states[$key]);
    }

    public function purge(): void
    {
        $this->states = [];
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->states);
    }
}
