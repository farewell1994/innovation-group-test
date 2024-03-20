<?php

namespace App\Controller\ClientBonus;

use App\Entity\ClientBonus\ClientBonus;
use App\Model\Paginator\Paginator;
use App\Repository\Client\ClientRepository;
use App\Repository\ClientBonus\ClientBonusRepository;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClientBonusListController extends AbstractController
{
    #[Route('/api/client-bonus/{clientId}', requirements: ['clientId' => '\d+'], methods: ['GET'])]
    #[OA\Parameter(
        name: 'limit',
        in: 'query',
        schema: new OA\Schema(type: 'int', default: Paginator::DEFAULT_LIMIT)
    )]
    #[OA\Parameter(
        name: 'page',
        in: 'query',
        schema: new OA\Schema(type: 'int', default: 1)
    )]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'List of client bonuses',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: ClientBonus::class, groups: ['api_response']))
        )
    )]
    #[OA\Tag(name: 'Client bonuses')]
    public function __invoke(
        int $clientId,
        ClientBonusRepository $clientBonuses,
        ClientRepository $clients
    ): Response {
        if ($client = $clients->find($clientId)) {
            $data = $clientBonuses->getBonusesByClient($client);
            $status = Response::HTTP_OK;
        } else {
            $data = "Client $clientId not found";
            $status = Response::HTTP_BAD_REQUEST;
        }

        return $this->json($data, $status);
    }
}
