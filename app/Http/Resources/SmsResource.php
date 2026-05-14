<?php

namespace App\Http\Resources;

use App\Models\SmsMessage;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin SmsMessage
 */
class SmsResource extends JsonResource
{
    final public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'to' => $this->to,
            'message' => $this->message,
            'status' => $this->status,
            'provider' => $this->provider,
            'externalId' => $this->external_id,
            'sentAt' => $this->sent_at,
        ];
    }
}
