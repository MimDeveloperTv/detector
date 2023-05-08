<?php

namespace App\Foundation\Transporter\Middlewares;

use Exception;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class RetryHttpCalls
{
    private int $retries;

    public function __invoke(int $retries): callable
    {
        $this->retries = $retries;

        return Middleware::retry($this->retryDecider(), $this->retryDelay());
    }

    private function retryDecider(): \Closure
    {
        return function (
            $retries,
            RequestInterface $request,
            ResponseInterface $response = null,
            Exception $exception = null
        ) {
            if ($retries == $this->retries - 1) {
                return false;
            }

            if ($exception instanceof ConnectException) {
                return true;
            }

            if ($response && $response->getStatusCode() >= 500) {
                return true;
            }

            return false;
        };
    }

    private function retryDelay(): \Closure
    {
        return function ($numberOfRetries) {
            return 250 * $numberOfRetries;
        };
    }
}
