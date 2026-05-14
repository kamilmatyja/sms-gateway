<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

/** @mixin LengthAwarePaginator */
class SmsResourceCollection extends ResourceCollection
{
    final public function toArray(Request $request): array
    {
        return [
            'data' => SmsResource::collection($this->collection)->resolve(),
        ];
    }

    final public function with($request): array
    {
        return [
            'meta' => [
                'page' => $this->currentPage(),
                'per_page' => $this->perPage(),
                'last_page' => $this->lastPage(),
            ],
        ];
    }
}
