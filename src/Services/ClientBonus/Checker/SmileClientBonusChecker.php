<?php

declare(strict_types=1);

namespace App\Services\ClientBonus\Checker;

use App\Entity\Client\Client;

class SmileClientBonusChecker extends AbstractClientBonusChecker
{
    protected function isClientSuitable(Client $client): bool
    {
        return $client->isEmailVerified();
    }

    protected function getAvailableBonuses(Client $client): array
    {
        return $this->bonuses->getSmileBonusesForClient($client);
    }
}
