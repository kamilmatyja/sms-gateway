<?php

namespace Tests\Unit;

use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class ApiResponseTest extends TestCase
{
    final public function test_created_returns_correct_json_response(): void
    {
        $id = '12345';
        $response = ApiResponse::created($id);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals(['id' => $id], $response->getData(true));
    }
}

