<?php

declare(strict_types=1);

namespace App\Controller\ClientBonus;

use App\Controller\Traits\ResponseTrait;
use App\Repository\Client\ClientRepository;
use App\Repository\ClientBonus\ClientBonusRepository;
use App\Services\Paginator\ClientBonusPaginator;
use App\Services\Paginator\Paginator;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClientBonusListController extends AbstractController
{
    use ResponseTrait;

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
            items: new OA\Items(ref: new Model(type: ClientBonusPaginator::class))
        )
    )]
    #[OA\Tag(name: 'Client bonuses')]
    public function __invoke(
        int $clientId,
        ClientBonusRepository $clientBonuses,
        ClientRepository $clients,
        ClientBonusPaginator $paginator
    ): JsonResponse {
        if ($client = $clients->find($clientId)) {
            $query = $clientBonuses->getBonusesByClientQuery($client);
            $data = $paginator->paginate($query);

            return $this->successResponse($data);
        }

        return $this->errorResponse("Client $clientId not found");
    }
}
