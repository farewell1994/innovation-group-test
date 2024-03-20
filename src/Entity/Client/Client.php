<?php

namespace App\Entity\Client;

use App\Entity\Bonus\Bonus;
use Symfony\Component\Serializer\Attribute\Groups;
use App\Entity\ClientBonus\ClientBonus;
use App\Entity\Traits\ActionDateTrait;
use App\Repository\Client\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Client implements \JsonSerializable
{
    use ActionDateTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["api_response"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["api_response"])]
    private string $email;

    #[ORM\Column(type: 'date')]
    #[Groups(["api_response"])]
    private \DateTime $birthday;

    #[ORM\Column]
    #[Groups(["api_response"])]
    private bool $isEmailVerified;

    #[ORM\OneToMany(targetEntity: ClientBonus::class, mappedBy: 'client')]
    private Collection $clientBonuses;

    public function __construct()
    {
        $this->isEmailVerified = false;
        $this->clientBonuses = new ArrayCollection();
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

    public function isBirthday(): bool
    {
        $today = new \DateTime('today');

        return $this->birthday->format('d-m') === $today->format('d-m');
    }

    public function hasBonus(Bonus $bonus): bool
    {
        return $this->clientBonuses->exists(function ($key, $element) use ($bonus) {
            return $element->getBonus() === $bonus;
        });
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'email' => $this->getEmail(),
            'birthday' => $this->getBirthday()->format('c'),
            'isEmailVerified' => $this->isEmailVerified(),
            'dateCreate' => $this->getDateCreate()->format('c'),
        ];
    }

    public function __toString(): string
    {
        return $this->getId();
    }
}
