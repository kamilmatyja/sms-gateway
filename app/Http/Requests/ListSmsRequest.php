<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property ?int $page
 * @property ?int $perPage
 * @property ?string $sort
 * @property ?string $status
 */
class ListSmsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'page' => ['integer', 'min:1'],
            'perPage' => ['integer', 'min:-1', 'max:100'],

            'sort' => [
                'string',
                Rule::in([
                    'sent_at:asc',
                    'sent_at:desc',
                ]),
            ],

            'status' => [
                'string',
                Rule::in([
                    'sent',
                    'failed',
                    'queued',
                ]),
            ],
        ];
    }
}
