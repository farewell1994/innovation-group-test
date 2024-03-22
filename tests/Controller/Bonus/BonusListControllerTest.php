<?php

declare(strict_types=1);

namespace App\Tests\Controller\Bonus;

use App\Enum\Bonus\BonusTypeEnum;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BonusListControllerTest extends WebTestCase
{
    public function testList(): void
    {
        $client = static::createClient();
        $limit = 2;

        $client->request(
            'GET',
            '/api/bonus',
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
        $this->assertIsInt($content['currentPage']);
        $this->assertSame($content['pagesCount'], (int) ceil($content['total'] / $content['limit']));
        $this->assertIsArray($content['items']);
        $this->assertLessThanOrEqual($limit, count($content['items']));

        foreach ($content['items'] as $item) {
            $this->assertIsInt($item['id']);
            $this->assertIsString($item['dateCreate']);
            $this->assertIsString($item['name']);
            $this->assertIsString($item['type']);
            $this->assertStringContainsString($item['type'], BonusTypeEnum::class);
        }
    }
}
