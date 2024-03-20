<?php

namespace App\Entity\ClientBonus;

use App\Entity\Bonus\Bonus;
use App\Entity\Client\Client;
use App\Entity\Traits\ActionDateTrait;
use OpenApi\Attributes as OA;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class ClientBonus implements \JsonSerializable
{
    use ActionDateTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'bonuses')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Client $client;

    #[ORM\ManyToOne(targetEntity: Bonus::class, inversedBy: 'clients')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[OA\Property(type: 'int')]
    private Bonus $bonus;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function setClient(Client $client): ClientBonus
    {
        $this->client = $client;
        $this->client->addClientBonus($this);

        return $this;
    }

    public function getBonus(): Bonus
    {
        return $this->bonus;
    }

    public function setBonus(Bonus $bonus): ClientBonus
    {
        $this->bonus = $bonus;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'dateCreated' => $this->getDateCreate(),
            'bonus' => $this->getBonus()->jsonSerialize(),
            'client' => $this->getClient()->jsonSerialize(),
        ];
    }
}