<?php

namespace App\Foundation\Transporter\Middlewares;

use App\Foundation\Logging\HttpClient\HttpLogger;
use GuzzleHttp\Promise as P;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Promise\RejectedPromise;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class LogHttpCalls
{
    protected HttpLogger $logger;

    public function __construct(HttpLogger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Called when the middleware is handled by the client.
     *
     * @param  array  $context
     * @return callable
     */
    public function __invoke(array $context = []): callable
    {
        return function (callable $handler) use ($context): callable {
            return function (RequestInterface $request, array $options) use ($context, $handler): PromiseInterface {
                $start = microtime(true);

                /** @var FulfilledPromise|RejectedPromise $promise */
                $promise = $handler($request, $options);

                return $promise->then(
                    function (ResponseInterface $response) use ($context, $request, $start) {
                        $sec = microtime(true) - $start;
                        $this->logger->fulfilledLog($request, $response, $sec, $context);

                        return $response;
                    },
                    function (\Throwable $reason) use ($context, $request, $start, $options) {
                        $delay = $options['delay'] ?? 0;
                        $sec = microtime(true) - $start - ($delay * pow(10, -3));
                        $this->logger->rejectedLog($request, $reason, $sec, $context);

                        return P\Create::rejectionFor($reason);
                    },
                );
            };
        };
    }
}
