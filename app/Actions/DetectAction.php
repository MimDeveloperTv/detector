<?php

namespace App\Actions;

use App\Data\ProcessData;
use App\Exceptions\NotFoundException;
use App\Http\Requests\DetectRequest;
use App\Support\Detectors\Detectors;
use Illuminate\Support\Facades\Cache;
use Lorisleiva\Actions\Concerns\AsAction;

class DetectAction
{
    use AsAction;

    /**
     * @throws NotFoundException
     */
    public function handle(DetectRequest $request): ProcessData
    {
        $qrcode = $request->input('qrcode');
        $data = Cache::remember('qrcode:'.$qrcode, config('cache.ttl'), function () use ($qrcode) {
            foreach (Detectors::SERVICES as $service) {
                $isQrDetected = Detectors::make($service)->process($qrcode);

                if ($isQrDetected) {
                    return $isQrDetected;
                }
            }

            return null;
        });

        if (! $data) {
            throw new NotFoundException();
        }

        return $data;
    }
}
