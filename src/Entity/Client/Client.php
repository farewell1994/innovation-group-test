<?php

namespace App\Entity\Client;

use App\Entity\Traits\ActionDateTrait;
use App\Repository\Client\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    use ActionDateTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $email;

    #[ORM\Column(type: 'date')]
    private \DateTime $birthday;

    #[ORM\Column]
    private bool $isEmailVerified;

    #[ORM\OneToMany(targetEntity: ClientBonus::class, mappedBy: 'client')]
    private Collection $bonuses;

    public function __construct()
    {
        $this->dateCreate = new \DateTime();
        $this->birthday = new \DateTime();
        $this->isEmailVerified = false;
        $this->bonuses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): Client
    {
        $this->email = $email;

        return $this;
    }

    public function getBirthday(): \DateTime
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTime $birthday): Client
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function isEmailVerified(): bool
    {
        return $this->isEmailVerified;
    }

    public function setIsEmailVerified(bool $isEmailVerified): Client
    {
        $this->isEmailVerified = $isEmailVerified;

        return $this;
    }
}
