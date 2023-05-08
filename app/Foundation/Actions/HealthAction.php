<?php

namespace App\Foundation\Actions;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\Health\ResultStores\ResultStore;

class HealthAction
{
    use AsAction;

    /**
     * @return JsonResponse
     */
    public function handle(): JsonResponse
    {
        $resultStore = app(ResultStore::class);

        Artisan::call('health:check --no-notification');

        $checkResults = $resultStore->latestResults();

        $failedChecksMessages =
            $checkResults->storedCheckResults
                ->where('status', 'failed')
                ->pluck('notificationMessage', 'name')
                ->toArray();

        return response()->json([
            'status' => $checkResults->allChecksOk(),
            'message' => $failedChecksMessages,
        ])->setStatusCode($checkResults->allChecksOk() ? 200 : 503);
    }
}
