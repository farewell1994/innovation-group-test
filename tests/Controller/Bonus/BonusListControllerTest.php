<?php

declare(strict_types=1);

namespace App\Tests\Controller\Bonus;

use App\Tests\Controller\Traits\AssertBonusTrait;
use App\Tests\Controller\Traits\AssertPaginationTrait;
use App\Tests\Controller\Traits\ProcessResponseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BonusListControllerTest extends WebTestCase
{
    use AssertPaginationTrait, AssertBonusTrait, ProcessResponseTrait;

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

        $content = $this->processSuccessResponse($client->getResponse()->getContent());
        $this->assertPagination($content, $limit);

        foreach ($content['items'] as $item) {
            $this->assertBonus($item);
        }
    }
}
