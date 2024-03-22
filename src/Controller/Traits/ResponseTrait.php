<?php

declare(strict_types=1);

namespace App\Controller\Traits;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ResponseTrait
{
    public function successResponse(mixed $data): JsonResponse
    {
        return $this->json($data, Response::HTTP_OK);
    }

    public function errorResponse(mixed $data): JsonResponse
    {
        return $this->json($data, Response::HTTP_BAD_REQUEST);
    }
}
