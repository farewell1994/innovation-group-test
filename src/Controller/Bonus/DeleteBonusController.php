<?php

declare(strict_types=1);

namespace App\Controller\Bonus;

use App\Controller\Traits\ResponseTrait;
use App\Manager\BaseManager;
use App\Repository\Bonus\BonusRepository;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DeleteBonusController extends AbstractController
{
    use ResponseTrait;

    #[Route('/api/bonus/{bonusId}', requirements: ['bonusId' => '\d+'], methods: ['DELETE'])]
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
    #[OA\Tag(name: 'Bonuses')]
    public function __invoke(
        int $bonusId,
        BaseManager $manager,
        BonusRepository $bonuses
    ): JsonResponse {
        if ($bonus = $bonuses->find($bonusId)) {
            $manager->delete($bonus);

            return $this->successResponse("Bonus $bonusId was deleted successfully");
        }

        return $this->errorResponse("Bonus $bonusId not found");
    }
}
