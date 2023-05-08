<?php

namespace App\Data;

class ProcessData
{
    public ?string $type;
    public ?string $serviceName;
    public ?array $metadata;

    public function __construct(?string $type, ?string $serviceName, ?array $metadata)
    {
        $this->type = $type;
        $this->serviceName = $serviceName;
        $this->metadata = $metadata;
    }

    public static function make(string $type, string $serviceName, array $metadata): static
    {
        return new static(
            $type,
            $serviceName,
            $metadata
        );
    }
}
