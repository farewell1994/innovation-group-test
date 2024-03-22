<?php

declare(strict_types=1);

namespace App\Entity\ClientBonus;

use App\Entity\Bonus\Bonus;
use App\Entity\Client\Client;

class ClientBonusFactory
{
    public static function init(Client $client, Bonus $bonus): ClientBonus
    {
        return (new ClientBonus())
            ->setClient($client)
            ->setBonus($bonus);
    }
}
