<?php

namespace App\Controller\Client;

use App\Entity\Client\Client;
use App\Manager\Client\ClientManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

class VerifyEmailController extends AbstractController
{
    #[Route('/api/client/verify-email/{client}', methods: ['PUT'])]
    #[OA\Tag(name: 'Clients')]
    public function __invoke(Client $client, ClientManager $manager): Response
    {
        $manager->verifyEmail($client);

        return $this->json('Email was verified');
    }
}
