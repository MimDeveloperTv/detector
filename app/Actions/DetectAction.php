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
    public function handle(DetectRequest $request)
    {
        $input = $request->input('input');
        foreach (Detectors::SERVICES as $service) {
            return Detectors::make($service)->process($input);
        }
        return 'empty';

    }
}
