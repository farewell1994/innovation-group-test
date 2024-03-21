<?php

namespace App\Controller\Client;

use App\Manager\Client\ClientManager;
use App\Repository\Client\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

class VerifyEmailController extends AbstractController
{
    #[Route('/api/client/verify-email/{clientId}', requirements: ['clientId' => '\d+'] , methods: ['PATCH'])]
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
    ): Response {
        if ($client = $clients->find($clientId)) {
            $manager->verifyEmail($client);

            $message = "Client $clientId email was verified";
            $status = Response::HTTP_OK;

        } else {
            $message = "Client $clientId not found";
            $status = Response::HTTP_BAD_REQUEST;
        }

        return $this->json($message, $status);
    }
}
