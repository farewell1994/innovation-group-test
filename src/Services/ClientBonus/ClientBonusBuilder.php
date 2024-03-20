<?php

namespace App\Services\ClientBonus;

use App\Entity\Client\Client;
use App\Services\ClientBonus\Checker\HugClientBonusChecker;
use App\Services\ClientBonus\Checker\SmileClientBonusChecker;

class ClientBonusBuilder implements CollectionBuilderInterface
{
    public function __construct(
        private readonly HugClientBonusChecker $hugClientBonusChecker,
        private readonly SmileClientBonusChecker $smileClientBonusChecker
    ) {}

    private Client $client;

    private array $bonuses = [];

    public function init(Client $client): void
    {
        $this->client = $client;
    }

    public function addElements(): void
    {
        $this->bonuses = array_merge(
            $this->hugClientBonusChecker->checkClientBonuses($this->client),
            $this->smileClientBonusChecker->checkClientBonuses($this->client)
        );
    }

    public function getCollection(): array
    {
        return $this->bonuses;
    }
}
