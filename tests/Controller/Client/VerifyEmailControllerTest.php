<?php

declare(strict_types=1);

namespace App\Tests\Controller\Client;

use App\Entity\Client\ClientFactory;
use App\Repository\Client\ClientRepository;
use App\Tests\Controller\Traits\ProcessResponseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VerifyEmailControllerTest extends WebTestCase
{
    use ProcessResponseTrait;

    public function testVerifyEmailSuccess(): void
    {
        $client = static::createClient();
        $clientId = static::getContainer()
            ->get(ClientRepository::class)
            ->findOneByEmail(ClientFactory::TEST_EMAIL)
            ?->getId();

        $client->request(
            'PATCH',
            '/api/client/verify-email/' . $clientId,
        );

        $content = $this->processSuccessResponse($client->getResponse()->getContent());

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

        $content = $this->processErrorResponse($client->getResponse()->getContent());

        $this->assertSame("Client $clientId not found", $content);
    }
}
