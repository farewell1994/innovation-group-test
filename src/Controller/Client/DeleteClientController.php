<?php

namespace App\Controller\Client;

use App\Manager\BaseManager;
use App\Repository\Client\ClientRepository;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DeleteClientController extends AbstractController
{
    #[Route('/api/client/{clientId}', requirements: ['clientId' => '\d+'], methods: ['DELETE'])]
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
        BaseManager $manager,
        ClientRepository $clients
    ): JsonResponse {
        if ($client = $clients->find($clientId)) {
            $manager->delete($client);
            $message = "Client $clientId was deleted successfully";
            $status = Response::HTTP_OK;
        } else {
            $message = "Client $clientId not found";
            $status = Response::HTTP_BAD_REQUEST;
        }

        return $this->json($message, $status);
    }
}
