<?php

declare(strict_types=1);

namespace App\Manager\Client;

use App\Entity\Client\Client;
use App\Manager\BaseManager;

class ClientManager extends BaseManager
{
    public function verifyEmail(Client $client): Client
    {
        if (!$client->isEmailVerified()) {
            $client->setIsEmailVerified(true);

            $this->update($client);
        }

        return $client;
    }
}
