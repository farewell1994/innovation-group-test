<?php

namespace App\Services\ClientBonus;

use App\Entity\Client\Client;
use App\Entity\ClientBonus\ClientBonusFactory;
use App\Manager\BaseManager;
use App\Repository\Bonus\BonusRepository;

class BonusChecker
{
    public function __construct(
        private readonly BonusRepository $bonuses,
        private readonly BaseManager $manager
    ) {}

    public function checkClientBonuses(Client $client): array
    {
        $isBirthday = $client->isBirthday();
        $isEmailVerified = $client->isEmailVerified();

        $bonuses = $result = [];

        if ($isBirthday) {
            $bonuses = $this->bonuses->getHugBonuses();
        }

        if ($isEmailVerified) {
            $bonuses = array_merge($bonuses, $this->bonuses->getSmileBonuses());
        }

        foreach ($bonuses as $bonus) {
            if (!$client->hasBonus($bonus)) {
                $clientBonus = ClientBonusFactory::init($client, $bonus);
                $this->manager->save($clientBonus);
                $result[] = $clientBonus;
            }
        }

        return $result;
    }
}
