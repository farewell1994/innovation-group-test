<?php

declare(strict_types=1);

namespace App\Services\ClientBonus\Checker;

class ClientBonusCheckerPool
{
    private array $checkers;

    public function addClientBonusChecker(ClientBonusCheckerInterface $bonusChecker): void
    {
        $this->checkers[] = $bonusChecker;
    }

    public function getClientBonusCheckers(): array
    {
        return $this->checkers;
    }
}
