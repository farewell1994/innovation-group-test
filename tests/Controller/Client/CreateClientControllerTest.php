<?php

declare(strict_types=1);

namespace App\Tests\Controller\Client;

use App\Entity\Client\ClientFactory;
use App\Tests\Controller\Traits\AssertClientTrait;
use App\Tests\Controller\Traits\ProcessResponseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CreateClientControllerTest extends WebTestCase
{
    use ProcessResponseTrait;
    use AssertClientTrait;

    public function testSuccessfullyClientCreate(): void
    {
        $email = ClientFactory::TEST_EMAIL;
        $birthday = (new \DateTime('-20 years'))->format('Y-m-d');

        $client = static::createClient();
        $client->request(
            'POST',
            '/api/client',
            compact('email', 'birthday'),
            [],
            ['CONTENT_TYPE' => 'multipart/form-data']
        );

        $this->assertSuccessResponse($client->getResponse(), $email, $birthday);
    }

    public function testSuccessfullyClientToDeleteCreate(): void
    {
        $email = ClientFactory::TEST_EMAIL_TO_DELETE;
        $birthday = (new \DateTime('-30 years'))->format('Y-m-d');

        $client = static::createClient();
        $client->request(
            'POST',
            '/api/client',
            compact('email', 'birthday'),
            [],
            ['CONTENT_TYPE' => 'multipart/form-data']
        );

        $this->assertSuccessResponse($client->getResponse(), $email, $birthday);
    }

    public function testInvalidCreation(): void
    {
        $birthday = (new \DateTime('-20 years'))->format('Y-m-d');

        $client = static::createClient();
        $client->request(
            'POST',
            '/api/client',
            compact('birthday'),
            [],
            ['CONTENT_TYPE' => 'multipart/form-data']
        );

        $content = $this->processErrorResponse($client->getResponse()->getContent());

        $this->assertSame([
            [
                'origin' => 'email',
                'message' => 'This value should not be blank.',
            ],
        ], $content);
    }

    private function assertSuccessResponse(Response $response, string $email, string $birthday): void
    {
        $content = $this->processSuccessResponse($response->getContent());
        $this->assertClient($content);
        $this->assertSame($email, $content['email']);
        $this->assertStringContainsString($birthday, $content['birthday']);
    }
}
