<?php

declare(strict_types=1);

namespace App\Tests\Controller\Client;

use App\Entity\Client\ClientFactory;
use App\Repository\Client\ClientRepository;
use App\Tests\Controller\Traits\ProcessResponseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DeleteClientControllerTest extends WebTestCase
{
    use ProcessResponseTrait;

    public function testSuccessDelete(): void
    {
        $client = static::createClient();
        $clientId = static::getContainer()
            ->get(ClientRepository::class)
            ->findOneByEmail(ClientFactory::TEST_EMAIL_TO_DELETE)
            ?->getId();

        $client->request(
            'DELETE',
            '/api/client/' . $clientId,
        );

        $content = $this->processSuccessResponse($client->getResponse()->getContent());

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

        $content = $this->processErrorResponse($client->getResponse()->getContent());

        $this->assertSame("Client $clientId not found", $content);
    }
}
