<?php

declare(strict_types=1);

namespace App\Controller\Client;

use App\Controller\Traits\ResponseTrait;
use App\Repository\Client\ClientRepository;
use App\Services\Paginator\ClientPaginator;
use App\Services\Paginator\Paginator;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClientListController extends AbstractController
{
    use ResponseTrait;

    #[Route('/api/client', methods: ['GET'])]
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
        description: 'List of clients',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: ClientPaginator::class))
        )
    )]
    #[OA\Tag(name: 'Clients')]
    public function __invoke(
        Request $request,
        ClientRepository $clients,
        ClientPaginator $paginator
    ): JsonResponse {
        $query = $clients->getClientsQuery();
        $paginator->paginate($query);

        return $this->successResponse($paginator);
    }
}
