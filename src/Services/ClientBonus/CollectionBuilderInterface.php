<?php

namespace App\Services\ClientBonus;

use App\Entity\Client\Client;

interface CollectionBuilderInterface
{
    public function init(Client $client): void;

    public function addElements(): void;

    public function getCollection(): array;
}
