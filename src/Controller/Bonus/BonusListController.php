<?php

namespace App\Controller\Bonus;

use App\Entity\Bonus\Bonus;
use App\Model\Paginator\Paginator;
use App\Model\Paginator\PaginatorFactory;
use App\Repository\Bonus\BonusRepository;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BonusListController extends AbstractController
{
    #[Route('/api/bonus', methods: ['GET'])]
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
        description: 'List of bonuses',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Bonus::class))
        )
    )]
    #[OA\Tag(name: 'Bonuses')]
    public function __invoke(Request $request, BonusRepository $bonuses): Response
    {
        $paginator = PaginatorFactory::init($request);

        return $this->json($bonuses->getBonuses($paginator));
    }
}
