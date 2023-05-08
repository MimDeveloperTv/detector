<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed qrcode
 **/
class DetectRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'qrcode' => 'required',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['user_id' => $this->header('X-User-Id')]);
    }
}
