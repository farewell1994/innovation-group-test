<?php

namespace App\Tests\Controller\Client;

use App\Entity\Client\ClientFactory;
use App\Repository\Client\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class VerifyEmailControllerTest extends WebTestCase
{
    public function testVerifyEmailSuccess(): void
    {
        $client = static::createClient();
        $clientId = $this->getClientId();

        $client->request(
            'PATCH',
            '/api/client/verify-email/' . $clientId,
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $response = $client->getResponse();

        $content = json_decode($response->getContent(), true);

        $this->assertSame("Client $clientId email was verified", $content);
    }

    public function testVerifyEmailFail(): void
    {
        $client = static::createClient();
        $clientId = 9999999;

        $client->request(
            'PATCH',
            '/api/client/verify-email/' . $clientId,
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $content = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame("Client $clientId not found", $content);
    }

    private function getClientId(): int
    {
        /** @var ClientRepository $clients */
        $clients = static::getContainer()
            ->get(ClientRepository::class);

        $qb = $clients->createQueryBuilder('c');

        return (int) $qb
            ->select('c.id')
            ->where($qb->expr()->eq('c.email',  ':email'))
            ->setMaxResults(1)
            ->setParameter('email', ClientFactory::TEST_EMAIL)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
