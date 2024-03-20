<?php

namespace App\Controller\Bonus;

use App\Manager\BaseManager;
use App\Repository\Bonus\BonusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

class DeleteBonusController extends AbstractController
{
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
    ): Response {
        if ($bonus = $bonuses->find($bonusId)) {
            $manager->delete($bonus);

            $message = 'Bonus was deleted successfully';
            $status = Response::HTTP_OK;
        } else {
            $message = "Bonus $bonusId not found";
            $status = Response::HTTP_BAD_REQUEST;
        }

        return $this->json($message, $status);
    }
}
