<?php

namespace App\Controller\ClientBonus;

use App\Entity\Client\Client;
use App\Repository\ClientBonus\ClientBonusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BonusListController extends AbstractController
{
    #[Route('/api/client-bonus/{client}', methods: ['GET'])]
    #[OA\Tag(name: 'Client bonuses')]
    public function __invoke(Client $client, ClientBonusRepository $clientBonuses): Response
    {
        $clientBonuses = $clientBonuses->getBonusesByClient($client);

        return $this->json($clientBonuses);
    }
}
