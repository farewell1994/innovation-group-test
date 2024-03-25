<?php

declare(strict_types=1);

namespace App\Tests\Controller\Traits;

trait AssertClientBonusTrait
{
    use AssertClientTrait, AssertBonusTrait;
    public function assertClientBonus(array $content, int $clientId): void
    {
        $this->assertIsInt($content['id']);
        $this->assertIsString($content['dateCreate']);
        $this->assertIsArray($content['client']);
        $this->assertClient($content['client']);
        $this->assertIsArray($content['bonus']);
        $this->assertBonus($content['bonus']);
        $this->assertSame($clientId, $content['client']['id']);
    }
}
