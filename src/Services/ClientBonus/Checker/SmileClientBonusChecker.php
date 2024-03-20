<?php

namespace App\Services\ClientBonus\Checker;

use App\Entity\Client\Client;

class SmileClientBonusChecker extends AbstractClientBonusChecker
{
    protected function isClientSuitable(Client $client): bool
    {
        return $client->isEmailVerified();
    }

    protected function getAvailableBonuses(): array
    {
        return $this->bonuses->getSmileBonuses();
    }
}
