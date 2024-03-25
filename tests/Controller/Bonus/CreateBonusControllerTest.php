<?php

declare(strict_types=1);

namespace App\Tests\Controller\Bonus;

use App\Entity\Bonus\BonusFactory;
use App\Enum\Bonus\BonusTypeEnum;
use App\Tests\Controller\Traits\AssertBonusTrait;
use App\Tests\Controller\Traits\ProcessResponseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CreateBonusControllerTest extends WebTestCase
{
    use ProcessResponseTrait;
    use AssertBonusTrait;

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

        $content = $this->processErrorResponse($client->getResponse()->getContent());

        $this->assertSame([
            [
                'origin' => 'name',
                'message' => 'This value should not be blank.',
            ],
            [
                'origin' => 'type',
                'message' => 'This value should not be blank.',
            ],
        ], $content);
    }

    private function assertSuccessResponse(Response $response, string $bonusName, string $bonusType): void
    {
        $content = $this->processSuccessResponse($response->getContent());
        $this->assertBonus($content);
        $this->assertSame($bonusName, $content['name']);
        $this->assertSame($bonusType, $content['type']);
    }
}
