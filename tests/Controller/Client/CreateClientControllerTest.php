<?php

namespace App\Tests\Controller\Client;

use App\Entity\Client\ClientFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CreateClientControllerTest extends WebTestCase
{
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

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);

        $this->assertSame([
            [
                'origin' => 'email',
                'message' => 'This value should not be blank.'
            ],
        ], $content);
    }

    private function assertSuccessResponse(Response $response, string $email, string $birthday): void
    {
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $content = json_decode($response->getContent(), true);

        $this->assertIsInt($content['id']);
        $this->assertIsString($content['dateCreate']);
        $this->assertSame($email, $content['email']);
        $this->assertStringContainsString($birthday, $content['birthday']);
    }
}
