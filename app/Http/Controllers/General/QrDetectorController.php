<?php

namespace App\Http\Controllers\General;

use App\Actions\DetectAction;
use App\Foundation\Units\Controller as BaseController;
use App\Http\Requests\DetectRequest;
use App\Http\Resources\General\DetectResource;

class QrDetectorController extends BaseController
{
    /**
     * @throws \App\Exceptions\NotFoundException
     */
    public function __invoke(DetectRequest $request)
    {
        $response = DetectAction::make()->handle($request);

        return DetectResource::make($response);
    }
}
