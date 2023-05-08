<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed qrcode
 **/
class DetectRequest extends FormRequest
{
    public function rules()
    {
        return [
            'input' => 'required',
        ];
    }
}
