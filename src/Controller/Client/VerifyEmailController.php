<?php

declare(strict_types=1);

namespace App\Controller\Client;

use App\Controller\Traits\ResponseTrait;
use App\Manager\Client\ClientManager;
use App\Repository\Client\ClientRepository;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VerifyEmailController extends AbstractController
{
    use ResponseTrait;

    #[Route('/api/client/verify-email/{clientId}', requirements: ['clientId' => '\d+'], methods: ['PATCH'])]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Successfully action',
        content: new OA\JsonContent(
            type: 'string'
        )
    )]
    #[OA\Response(
        response: Response::HTTP_BAD_REQUEST,
        description: 'Bad request',
        content: new OA\JsonContent(
            type: 'string'
        )
    )]
    #[OA\Tag(name: 'Clients')]
    public function __invoke(
        int $clientId,
        ClientManager $manager,
        ClientRepository $clients
    ): JsonResponse {
        if ($client = $clients->find($clientId)) {
            $manager->verifyEmail($client);

            return $this->successResponse("Client $clientId email was verified");
        }

        return $this->errorResponse("Client $clientId not found");
    }
}
