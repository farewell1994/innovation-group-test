<?php

declare(strict_types=1);

namespace App\Tests\Controller\Traits;

use Symfony\Component\HttpFoundation\Response;

trait ProcessResponseTrait
{
    public function processSuccessResponse(string $response): array|string
    {
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        return $this->formatResponse($response);
    }

    public function processErrorResponse(string $response): array|string
    {
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertResponseHeaderSame('content-type', 'application/json');

        return $this->formatResponse($response);
    }

    private function formatResponse(string $response): array|string
    {
        return json_decode($response, true);
    }
}
