<?php

declare(strict_types=1);

namespace App\Tests\Controller\ClientBonus;

use App\Entity\Client\ClientFactory;
use App\Repository\Client\ClientRepository;
use App\Tests\Controller\Traits\AssertClientBonusTrait;
use App\Tests\Controller\Traits\AssertPaginationTrait;
use App\Tests\Controller\Traits\ProcessResponseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClientBonusListControllerTest extends WebTestCase
{
    use AssertPaginationTrait;
    use AssertClientBonusTrait;
    use ProcessResponseTrait;

    public function testListSuccess(): void
    {
        $client = static::createClient();
        $clientId = (int) static::getContainer()
            ->get(ClientRepository::class)
            ->findOneByEmail(ClientFactory::TEST_EMAIL)
            ?->getId();
        $limit = 2;

        $client->request(
            'GET',
            '/api/client-bonus/'.$clientId,
            [
                'page' => 1,
                'limit' => $limit,
            ],
        );

        $content = $this->processSuccessResponse($client->getResponse()->getContent());
        $this->assertPagination($content, $limit);

        foreach ($content['items'] as $item) {
            $this->assertClientBonus($item, $clientId);
        }
    }

    public function testListFail(): void
    {
        $client = static::createClient();
        $clientId = 9999999;

        $client->request(
            'GET',
            '/api/client-bonus/'.$clientId,
        );

        $content = $this->processErrorResponse($client->getResponse()->getContent());

        $this->assertSame("Client $clientId not found", $content);
    }
}
