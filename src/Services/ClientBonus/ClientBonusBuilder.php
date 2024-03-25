<?php

declare(strict_types=1);

namespace App\Services\ClientBonus;

use App\Entity\Client\Client;
use App\Services\ClientBonus\Checker\ClientBonusCheckerInterface;
use App\Services\ClientBonus\Checker\ClientBonusCheckerPool;

class ClientBonusBuilder implements CollectionBuilderInterface
{
    public function __construct(
        private readonly ClientBonusCheckerPool $clientBonusCheckerPool
    ) {
    }

    private Client $client;

    private array $bonuses = [];

    public function init(Client $client): void
    {
        $this->client = $client;
    }

    public function addElements(): void
    {
        /** @var ClientBonusCheckerInterface $clientBonusChecker */
        foreach ($this->clientBonusCheckerPool->getClientBonusCheckers() as $clientBonusChecker) {
            $this->bonuses = array_merge($this->bonuses, $clientBonusChecker->checkClientBonuses($this->client));
        }
    }

    public function getCollection(): array
    {
        return $this->bonuses;
    }
}
