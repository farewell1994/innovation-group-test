<?php

namespace App\Controller\Client;

use App\Entity\Client\Client;
use App\Model\Paginator\Paginator;
use App\Model\Paginator\PaginatorFactory;
use App\Repository\Client\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

class ClientListController extends AbstractController
{
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
            items: new OA\Items(ref: new Model(type: Client::class, groups: ['api_response']))
        )
    )]
    #[OA\Tag(name: 'Clients')]
    public function __invoke(Request $request, ClientRepository $clients): Response
    {
        $paginator = PaginatorFactory::init($request);

        return $this->json($clients->findAll());
    }
}
