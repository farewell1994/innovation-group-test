<?php

namespace App\Controller\ClientBonus;

use App\Entity\Bonus\Bonus;
use App\Entity\Client\Client;
use App\Entity\ClientBonus\ClientBonus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CheckBonusController extends AbstractController
{
    #[Route('/api/client-bonus/{client}', methods: ['POST'])]
    #[OA\Tag(name: 'Client bonuses')]
    public function __invoke(Client $client, EntityManagerInterface $em): Response
    {
        $bonusRepo = $em->getRepository(Bonus::class);
        $isBirthday = $client->isBirthday();
        $isEmailVerified = $client->isEmailVerified();

        $bonuses = [];

        if ($isBirthday) {
            $bonuses = $bonusRepo->getHugBonuses();
        }

        if ($isEmailVerified) {
            $bonuses = array_merge($bonuses, $bonusRepo->getSmileBonuses());
        }

        $result = [];

        if ($bonuses) {

            foreach ($bonuses as $bonus) {

                if (!$client->hasBonus($bonus)) {
                    $clientBonus = new ClientBonus();
                    $clientBonus->setClient($client);
                    $clientBonus->setBonus($bonus);

                    $em->persist($clientBonus);

                    $result[] = $bonus;
                }
            }

            $em->flush();
        }

        return new JsonResponse($result);
    }
}
