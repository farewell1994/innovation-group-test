<?php

namespace App\Controller\Client;

use App\Entity\Client\Client;
use App\Manager\BaseManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

class DeleteClientController extends AbstractController
{
    #[Route('/api/client/{client}', methods: ['DELETE'])]
    #[OA\Tag(name: 'Clients')]
    public function __invoke(Client $client, BaseManager $manager): Response
    {
        $manager->delete($client);

        return $this->json('Client was deleted successfully');
    }
}
