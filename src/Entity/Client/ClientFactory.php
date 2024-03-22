<?php

declare(strict_types=1);

namespace App\Entity\Client;

class ClientFactory
{
    public const TEST_EMAIL = 'test@i.ua';
    public const TEST_EMAIL_TO_DELETE = 'test_to_delete@i.ua';

    public static function create(?string $email = null, ?\DateTime $birthday = null): Client
    {
        $client = new Client();

        if ($email) {
            $client->setEmail($email);
        }

        if ($birthday) {
            $client->setBirthday($birthday);
        }

        return $client;
    }
}
