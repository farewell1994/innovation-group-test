<?php

declare(strict_types=1);

namespace App\Tests\Controller\Client;

use App\Entity\Client\ClientFactory;
use App\Repository\Client\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DeleteClientControllerTest extends WebTestCase
{
    public function testSuccessDelete(): void
    {
        $client = static::createClient();
        $clientId = $this->getClientIdToDelete();

        $client->request(
            'DELETE',
            '/api/client/' . $clientId,
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $content = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame("Client $clientId was deleted successfully", $content);
    }

    public function testInvalidDelete(): void
    {
        $client = static::createClient();
        $clientId = 9999999;
        $client->request(
            'DELETE',
            '/api/client/' . $clientId,
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $content = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame("Client $clientId not found", $content);
    }

    private function getClientIdToDelete(): int
    {
        /** @var ClientRepository $clients */
        $clients = static::getContainer()
            ->get(ClientRepository::class);

        $qb = $clients->createQueryBuilder('c');

        return (int) $qb
            ->select('c.id')
            ->where($qb->expr()->eq('c.email',  ':emailToDelete'))
            ->setMaxResults(1)
            ->setParameter('emailToDelete', ClientFactory::TEST_EMAIL_TO_DELETE)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
