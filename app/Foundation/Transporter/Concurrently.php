<?php

namespace App\Foundation\Transporter;

use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;

class Concurrently
{
    /**
     * Requests holder.
     *
     * @var array|Request[]
     */
    protected array $requests = [];

    /**
     * @param  HttpFactory  $http
     * @return void
     */
    public function __construct(
        private readonly HttpFactory $http
    ) {
    }

    /**
     * @param  array  $args
     * @return static
     */
    public function build(...$args): static
    {
        return app(static::class, $args);
    }

    /**
     * @param  array  $requests
     * @return static
     */
    public function setRequests(array $requests): static
    {
        $this->requests = [];
        foreach ($requests as $request) {
            if ($request->getAs() !== null) {
                $this->requests[$request->getAs()] = $request;
            } else {
                $this->requests[] = $request;
            }
        }

        return $this;
    }

    /**
     * @param  Request  $request
     * @return static
     */
    public function add(Request $request): static
    {
        if ($request->getAs() !== null) {
            $this->requests[$request->getAs()] = $request;
        } else {
            $this->requests[] = $request;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function run(): array
    {
        return collect($this->http->pool(fn (Pool $pool) => $this->buildRequestsPool($pool)))
            ->mapWithKeys(fn (Response $response, string|int $key) => [$key => $response])
            ->toArray();
    }

    /**
     * @param $pool
     * @return array
     */
    private function buildRequestsPool($pool): array
    {
        $requests = [];
        foreach ($this->requests as $request) {
            $requests[] = $request->buildForConcurrent($pool);
        }

        return $requests;
    }
}
