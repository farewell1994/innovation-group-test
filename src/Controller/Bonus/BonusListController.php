<?php

namespace App\Controller\Bonus;

use App\Repository\Bonus\BonusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BonusListController extends AbstractController
{
    #[Route('/bonuses', 'app_bonus_list')]
    public function list(Request $request, BonusRepository $bonuses): Response
    {
        return $this->render('bonus/list.html.twig', [
            'bonuses' => $bonuses->findAll()
        ]);
    }
}
