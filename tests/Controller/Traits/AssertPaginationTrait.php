<?php

declare(strict_types=1);

namespace App\Tests\Controller\Traits;

trait AssertPaginationTrait
{
    public function assertPagination(array $content, int $limit): void
    {
        $this->assertIsInt($content['total']);
        $this->assertSame($limit, $content['limit']);
        $this->assertIsInt($content['currentPage']);
        $this->assertSame($content['pagesCount'], (int) ceil($content['total'] / $content['limit']));
        $this->assertIsArray($content['items']);
        $this->assertLessThanOrEqual($limit, count($content['items']));
    }
}
