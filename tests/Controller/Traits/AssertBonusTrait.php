<?php

declare(strict_types=1);

namespace App\Tests\Controller\Traits;

trait AssertBonusTrait
{
    public function assertBonus(array $content): void
    {
        $this->assertIsInt($content['id']);
        $this->assertIsString($content['dateCreate']);
        $this->assertIsString($content['name']);
        $this->assertIsString($content['type']);
    }
}
