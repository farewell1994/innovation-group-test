<?php

namespace App\Controller\ClientBonus;

use App\Entity\ClientBonus\ClientBonus;
use App\Repository\Client\ClientRepository;
use App\Services\ClientBonus\ClientBonusBuilder;
use App\Services\ClientBonus\ClientBonusDirector;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Annotation\Model;

class CheckClientBonusController extends AbstractController
{
    #[Route('/api/client-bonus/{clientId}', requirements: ['clientId' => '\d+'], methods: ['POST'])]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'List of applied client bonuses',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: ClientBonus::class, groups: ['api_response']))
        )
    )]
    #[OA\Response(
        response: Response::HTTP_BAD_REQUEST,
        description: 'Bad request',
        content: new OA\JsonContent(
            type: 'string'
        )
    )]
    #[OA\Tag(name: 'Client bonuses')]
    public function __invoke(
        int $clientId,
        ClientBonusBuilder $clientBonusBuilder,
        ClientRepository $clients
    ): Response {
        if ($client = $clients->find($clientId)) {
            $data = (new ClientBonusDirector())->build($clientBonusBuilder, $client);
            $status = Response::HTTP_OK;
        } else {
            $data = "Client $clientId not found";
            $status = Response::HTTP_BAD_REQUEST;
        }

        return $this->json($data, $status);
    }
}
