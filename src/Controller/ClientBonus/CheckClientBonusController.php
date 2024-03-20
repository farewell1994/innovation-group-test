<?php

namespace App\Controller\ClientBonus;

use App\Entity\Client\Client;
use App\Entity\ClientBonus\ClientBonus;
use App\Services\ClientBonus\BonusChecker;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CheckClientBonusController extends AbstractController
{
    #[Route('/api/client-bonus/{client}', methods: ['POST'])]
//    #[OA\Response(
//        response: Response::HTTP_OK,
//        description: 'List of applied client bonuses',
//        content: new OA\JsonContent(
//            type: 'array',
//            items: new OA\Items(ref: new Model(type: ClientBonus::class))
//        )
//    )]
    #[OA\Tag(name: 'Client bonuses')]
    public function __invoke(Client $client, BonusChecker $bonusChecker): Response
    {
        return $this->json($bonusChecker->checkClientBonuses($client));
    }
}
