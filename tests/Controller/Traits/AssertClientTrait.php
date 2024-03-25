<?php

declare(strict_types=1);

namespace App\Tests\Controller\Traits;

trait AssertClientTrait
{
    public function assertClient(array $content): void
    {
        $this->assertIsInt($content['id']);
        $this->assertIsString($content['dateCreate']);
        $this->assertIsString($content['email']);
        $this->assertIsString($content['birthday']);
    }
}
