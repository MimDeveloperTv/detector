<?php

namespace App\Foundation\Health;

use Illuminate\Log\Logger;
use Spatie\Health\Checks\Check;
use Spatie\Health\Checks\Result;

class LogCheck extends Check
{
    public function run(): Result
    {
        $result = Result::make();

        try {
            app(Logger::class)->info('Checking if logs are writable');
        } catch (\Exception $e) {
            return $result->failed("Could not write to log file: `{$e->getMessage()}`");
        }

        return $result->ok();
    }
}
