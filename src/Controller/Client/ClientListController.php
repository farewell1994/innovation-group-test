<?php

namespace App\Controller\Client;

use App\Repository\Client\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

class ClientListController extends AbstractController
{
    #[Route('/api/client', methods: ['GET'])]
    #[OA\Tag(name: 'Clients')]
    public function __invoke(Request $request, ClientRepository $clients): Response
    {
        return $this->json($clients->findAll());
    }
}
