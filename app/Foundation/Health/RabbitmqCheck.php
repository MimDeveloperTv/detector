<?php

namespace App\Foundation\Health;

use Illuminate\Queue\QueueManager;
use Illuminate\Support\Facades\Config;
use Spatie\Health\Checks\Check;
use Spatie\Health\Checks\Result;
use VladimirYuldashev\LaravelQueueRabbitMQ\Queue\RabbitMQQueue;

class RabbitmqCheck extends Check
{
    protected string $connectionName = 'default';

    public function connectionName(string $connectionName): self
    {
        $this->connectionName = $connectionName;

        return $this;
    }

    public function run(): Result
    {
        $result = Result::make()->meta([
            'connection_name' => $this->connectionName,
        ]);

        try {
            $this->rabbitmqConnected();

            return $result->ok();
        } catch (\Exception $exception) {
            return $result->failed("An exception occurred when connecting to Rabbitmq: `{$exception->getMessage()}`");
        }
    }

    public function rabbitmqConnected(): bool
    {
        Config::set('queue.default', 'rabbitmq');

        /** @var QueueManager $queue */
        $queue = app(QueueManager::class);

        /** @var RabbitMQQueue $connection */
        $connection = $queue->setConnectionName('rabbitmq');

        return $connection->getConnection()->isConnected();
    }
}
