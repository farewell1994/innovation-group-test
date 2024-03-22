<?php

declare(strict_types=1);

namespace App\Tests\Controller\Bonus;

use App\Entity\Bonus\BonusFactory;
use App\Enum\Bonus\BonusTypeEnum;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CreateBonusControllerTest extends WebTestCase
{
    public function testSuccessfullySmileBonusCreate(): void
    {
        $client = static::createClient();

        $name = BonusFactory::TEST_BONUS_SMILE_NAME;
        $type = BonusTypeEnum::SMILE->value;

        $client->request(
            'POST',
            '/api/bonus',
            compact('name', 'type'),
            [],
            ['CONTENT_TYPE' => 'multipart/form-data'],
        );

        $this->assertSuccessResponse($client->getResponse(), $name, $type);
    }

    public function testSuccessfullyHugBonusCreate(): void
    {
        $client = static::createClient();

        $name = BonusFactory::TEST_BONUS_HUG_NAME;
        $type = BonusTypeEnum::HUG->value;

        $client->request(
            'POST',
            '/api/bonus',
            compact('name', 'type'),
            [],
            ['CONTENT_TYPE' => 'multipart/form-data']
        );

        $this->assertSuccessResponse($client->getResponse(), $name, $type);
    }

    public function testSuccessfullyBonusToDeleteCreate(): void
    {
        $name = BonusFactory::TEST_BONUS_FOR_DELETE_NAME;
        $type = BonusTypeEnum::SMILE->value;

        $client = static::createClient();
        $client->request(
            'POST',
            '/api/bonus',
            compact('name', 'type'),
            [],
            ['CONTENT_TYPE' => 'multipart/form-data']
        );

        $this->assertSuccessResponse($client->getResponse(), $name, $type);
    }

    public function testInvalidCreation(): void
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/bonus',
            [],
            [],
            ['CONTENT_TYPE' => 'multipart/form-data']
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);

        $this->assertSame([
            [
                'origin' => 'name',
                'message' => 'This value should not be blank.'
            ],
            [
                'origin' => 'type',
                'message' => 'This value should not be blank.'
            ]
        ], $content);
    }

    private function assertSuccessResponse(Response $response, string $bonusName, string $bonusType): void
    {
        $content = json_decode($response->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $this->assertIsInt($content['id']);
        $this->assertIsString($content['dateCreate']);
        $this->assertSame($bonusName, $content['name']);
        $this->assertSame($bonusType, $content['type']);
    }
}
