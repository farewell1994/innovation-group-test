<?php

namespace App\Entity\Client;

use App\Entity\Bonus\Bonus;
use App\Entity\Traits\ActionDateTrait;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class ClientBonus
{
    use ActionDateTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'bonuses')]
    #[ORM\JoinColumn(nullable: false)]
    private Client $client;

    #[ORM\ManyToOne(targetEntity: Bonus::class, inversedBy: 'clients')]
    #[ORM\JoinColumn(nullable: false)]
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
}
