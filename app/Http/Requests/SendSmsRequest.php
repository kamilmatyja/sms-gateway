<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $to
 * @property string $message
 */
class SendSmsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'to' => ['required', 'regex:/^[0-9]{9,15}$/'],
            'message' => ['required', 'string', 'min:4', 'max:256'],
        ];
    }
}
