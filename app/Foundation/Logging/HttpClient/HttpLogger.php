<?php

namespace App\Foundation\Logging\HttpClient;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface HttpLogger
{
    public function fulfilledLog(
        RequestInterface $request,
        ResponseInterface $response,
        float $sec,
        array $context = []
    ): void;

    public function rejectedLog(
        RequestInterface $request,
        \Throwable $exception,
        float $sec,
        array $context = []
    ): void;
}
