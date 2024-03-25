<?php

declare(strict_types=1);

namespace App\Services\ClientBonus\Checker;

use App\Entity\Client\Client;

interface ClientBonusCheckerInterface
{
    public function checkClientBonuses(Client $client): array;
}
