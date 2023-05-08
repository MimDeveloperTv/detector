<?php

namespace App\Foundation\Logging\Sentry;

use Sentry\SentrySdk;
use Sentry\Tracing\Span;
use Sentry\Tracing\SpanContext;
use Sentry\Tracing\Transaction;

class CustomInstrument
{
    private ?Transaction $transaction;
    private SpanContext $context;
    private ?Span $span;

    public static function build(): static
    {
        $instance = static::getInstance();
        $instance->setTransaction();
        $instance->setContext();

        return $instance;
    }

    public static function getInstance(): static
    {
        if (! app()->has(static::class)) {
            app()->singleton(static::class, fn () => new static());
        }

        return app(static::class);
    }

    public function setOpName(string $name): static
    {
        $this->context->setOp($name);

        return $this;
    }

    public function setDesc(string $description): static
    {
        $this->context->setDescription($description);

        return $this;
    }

    public function setData(array $data): static
    {
        $this->context->setData($data);

        return $this;
    }

    public function startSpan(): static
    {
        $this->span = $this->transaction?->startChild($this->context);

        return $this;
    }

    public function finishSpan(): void
    {
        $this->span?->finish();
    }

    private function setTransaction(): void
    {
        $this->transaction = SentrySdk::getCurrentHub()->getTransaction();
    }

    private function setContext(): void
    {
        $this->context = new SpanContext();
    }
}
