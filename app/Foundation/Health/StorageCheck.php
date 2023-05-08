<?php

namespace App\Foundation\Health;

use Illuminate\Support\Facades\Storage;
use Spatie\Health\Checks\Check;
use Spatie\Health\Checks\Result;

class StorageCheck extends Check
{
    public function run(): Result
    {
        $result = Result::make();

        $uniqueString = uniqid('check-storage-laravel_');

        $disk = config('filesystems.default');

        try {
            $storage = Storage::disk($disk);

            $storage->put($uniqueString, $uniqueString);

            $contents = $storage->get($uniqueString);

            $storage->delete($uniqueString);

            if ($contents !== $uniqueString) {
                return $result->failed("Some storage disks are not working $disk");
            }

            return $result->ok();
        } catch (\Exception $exception) {
            return $result->failed("Some storage disks are not working: `{$exception->getMessage()}`");
        }
    }
}
