<?php

declare(strict_types=1);

namespace App\Tests\Controller\ClientBonus;

use App\Entity\Client\ClientFactory;
use App\Repository\Client\ClientRepository;
use App\Tests\Controller\Traits\AssertClientBonusTrait;
use App\Tests\Controller\Traits\ProcessResponseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CheckClientBonusControllerTest extends WebTestCase
{
    use AssertClientBonusTrait;
    use ProcessResponseTrait;

    public function testCheckClientBonusSuccess(): void
    {
        $client = static::createClient();
        $clientId = (int) static::getContainer()
            ->get(ClientRepository::class)
            ->findOneByEmail(ClientFactory::TEST_EMAIL)
            ?->getId();

        $client->request(
            'POST',
            '/api/client-bonus/'.$clientId,
        );

        $content = $this->processSuccessResponse($client->getResponse()->getContent());
        $this->assertIsArray($content);

        foreach ($content as $item) {
            $this->assertClientBonus($item, $clientId);
        }
    }

    public function testCheckClientBonusFail(): void
    {
        $client = static::createClient();
        $clientId = 99999999;

        $client->request(
            'POST',
            '/api/client-bonus/'.$clientId,
        );

        $content = $this->processErrorResponse($client->getResponse()->getContent());

        $this->assertSame("Client $clientId not found", $content);
    }
}
