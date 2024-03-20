<?php

namespace App\Services\ClientBonus;

use App\Entity\Client\Client;

class ClientBonusDirector
{
    public function build(CollectionBuilderInterface $builder, Client $client): array
    {
        $builder->init($client);
        $builder->addElements();

        return $builder->getCollection();
    }
}
