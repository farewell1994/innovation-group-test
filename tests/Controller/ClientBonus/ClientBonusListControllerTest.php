<?php

namespace App\Tests\Controller\ClientBonus;

use App\Entity\Client\ClientFactory;
use App\Repository\Client\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ClientBonusListControllerTest extends WebTestCase
{
    public function testListSuccess(): void
    {
        $client = static::createClient();
        $clientId = $this->getClientId();
        $limit = 2;

        $client->request(
            'GET',
            '/api/client-bonus/' . $clientId,
            [
                'page' => 1,
                'limit' => $limit
            ],
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);

        $this->assertIsInt($content['total']);
        $this->assertSame($limit, $content['limit']);
        $this->assertIsInt(1, $content['currentPage']);
        $this->assertSame($content['pagesCount'], (int) ceil($content['total'] / $content['limit']));
        $this->assertIsArray($content['items']);
        $this->assertLessThanOrEqual($limit, count($content['items']));

        foreach ($content['items'] as $item) {
            $this->assertIsInt($item['id']);
            $this->assertIsString($item['dateCreate']);
            $this->assertIsArray($item['client']);
            $this->assertIsArray($item['bonus']);
            $this->assertSame($clientId, $item['client']['id']);
        }
    }

    public function testListFail(): void
    {
        $client = static::createClient();
        $clientId = 9999999;

        $client->request(
            'GET',
            '/api/client-bonus/' . $clientId,
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
