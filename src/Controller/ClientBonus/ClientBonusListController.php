<?php

namespace App\Controller\ClientBonus;

use App\Entity\Client\Client;
use App\Entity\ClientBonus\ClientBonus;
use App\Model\Paginator\Paginator;
use App\Repository\ClientBonus\ClientBonusRepository;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClientBonusListController extends AbstractController
{
    #[Route('/api/client-bonus/{client}', methods: ['GET'])]
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
//    #[OA\Response(
//        response: Response::HTTP_OK,
//        description: 'List of client bonuses',
//        content: new OA\JsonContent(
//            type: 'array',
//            items: new OA\Items(ref: new Model(type: ClientBonus::class))
//        )
//    )]
    #[OA\Tag(name: 'Client bonuses')]
    public function __invoke(Client $client, ClientBonusRepository $clientBonuses): Response
    {
        $clientBonuses = $clientBonuses->getBonusesByClient($client);

        return $this->json($clientBonuses);
    }
}
