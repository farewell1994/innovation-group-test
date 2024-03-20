<?php

namespace App\Services\ClientBonus\Checker;

use App\Entity\Bonus\Bonus;
use App\Entity\Client\Client;
use App\Entity\ClientBonus\ClientBonusFactory;
use App\Manager\BaseManager;
use App\Repository\Bonus\BonusRepository;
use Psr\Log\LoggerInterface;

abstract class AbstractClientBonusChecker
{
    public function __construct(
        protected readonly BonusRepository $bonuses,
        private readonly BaseManager $manager,
        private readonly LoggerInterface $logger,
    ) {}

    abstract protected function isClientSuitable(Client $client): bool;

    abstract protected function getAvailableBonuses(): array;

    public function checkClientBonuses(Client $client): array
    {
        return $this->isClientSuitable($client)
            ? $this->applyBonusesForClient($client, $this->getAvailableBonuses())
            : [];
    }

    private function applyBonusesForClient(Client $client, array $bonuses): array
    {
        $result = [];

        /** @var Bonus $bonus */
        foreach ($bonuses as $bonus) {
            if (!$client->hasBonus($bonus)) {
                $clientBonus = ClientBonusFactory::init($client, $bonus);
                $this->manager->save($clientBonus);
                $result[] = $clientBonus;

                $this->logger->info("Bonus $bonus was applied for client $client");
            }
        }

        return $result;
    }
}
