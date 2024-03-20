<?php

namespace App\Services\ClientBonus\Checker;

use App\Entity\Client\Client;

class HugClientBonusChecker extends AbstractClientBonusChecker
{
    protected function isClientSuitable(Client $client): bool
    {
        return $client->isBirthday();
    }

    protected function getAvailableBonuses(): array
    {
        return $this->bonuses->getHugBonuses();
    }
}
