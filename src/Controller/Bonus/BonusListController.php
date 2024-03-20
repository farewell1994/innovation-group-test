<?php

namespace App\Controller\Bonus;

use App\Repository\Bonus\BonusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

class BonusListController extends AbstractController
{
    #[Route('/api/bonus', methods: ['GET'])]
    #[OA\Tag(name: 'Bonuses')]
    public function __invoke(Request $request, BonusRepository $bonuses): Response
    {
        return $this->json($bonuses->findAll());
    }
}
