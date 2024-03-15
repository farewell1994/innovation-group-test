<?php

namespace App\Controller\Client\Bonus;

use App\Entity\Client\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CheckBonusController extends AbstractController
{
    #[Route('/client/bonus/check/{client}', 'app_client_bonus_check')]

    public function checkBonus(Client $client): Response
    {
        $this->addFlash('danger', 'no bonuses');

        return $this->redirect($this->generateUrl('app_client_list'));
    }
}
