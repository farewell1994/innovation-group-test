<?php

namespace App\Controller\Bonus;

use App\Entity\Bonus\Bonus;
use App\Manager\BaseManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

class DeleteBonusController extends AbstractController
{
    #[Route('/api/bonus/{bonus}', methods: ['DELETE'])]
//    #[OA\Parameter(
//        description: 'Bonus ID',
//        name: 'ID',
//        required: true,
//        in: 'path',
//        schema: new OA\Schema(type: 'int')
//    )]
    #[OA\Response(
        response: 200,
        description: 'Successfully action',
    )]
    #[OA\Tag(name: 'Bonuses')]
    public function __invoke(Bonus $bonus, BaseManager $manager): Response
    {
        $manager->delete($bonus);

        return $this->json('Bonus was deleted successfully');
    }
}
