<?php

use App\Foundation\Rules\IsUlid;

if (! function_exists('is_ulid')) {
    function is_ulid(string $identifier): bool
    {
        return (new IsUlid())->validate($identifier);
    }
}
