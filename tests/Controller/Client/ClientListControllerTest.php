<?php

declare(strict_types=1);

namespace App\Tests\Controller\Client;

use App\Tests\Controller\Traits\AssertClientTrait;
use App\Tests\Controller\Traits\AssertPaginationTrait;
use App\Tests\Controller\Traits\ProcessResponseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClientListControllerTest extends WebTestCase
{
    use AssertPaginationTrait, AssertClientTrait, ProcessResponseTrait;

    public function testList(): void
    {
        $client = static::createClient();
        $limit = 2;

        $client->request(
            'GET',
            '/api/client',
            [
                'page' => 1,
                'limit' => $limit
            ]
        );

        $content = $this->processSuccessResponse($client->getResponse()->getContent());
        $this->assertPagination($content, $limit);

        foreach ($content['items'] as $item) {
            $this->assertClient($item);
        }
    }
}
