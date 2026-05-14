<?php

namespace App\Http\Resources;

use App\Models\SmsMessage;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin SmsMessage
 */
class SmsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'to' => $this->to,
            'message' => $this->message,
            'status' => $this->status,
            'provider' => $this->provider,
            'external_id' => $this->external_id,
            'sent_at' => $this->sent_at,
        ];
    }
}
