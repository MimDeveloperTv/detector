<?php

namespace App\Foundation\Http\Middleware;

use App\Foundation\Exceptions\InvalidHeaderException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HasRequiredHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     *
     * @throws InvalidHeaderException
     */
    public function handle(Request $request, Closure $next)
    {
        $isUlid = Str::isUlid($request->header('X-User-Id'));

        if (! $isUlid) {
            throw new InvalidHeaderException();
        }

        return $next($request);
    }
}
