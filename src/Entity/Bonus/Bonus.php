<?php

namespace App\Entity\Bonus;
use App\Entity\Client\ClientBonus;
use App\Entity\Traits\ActionDateTrait;
use App\Enum\Bonus\BonusTypeEnum;
use App\Repository\Bonus\BonusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BonusRepository::class)]
class Bonus
{
    use ActionDateTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', enumType: BonusTypeEnum::class)]
    private BonusTypeEnum $type;

    #[ORM\OneToMany(targetEntity: ClientBonus::class, mappedBy: 'bonus')]
    private Collection $clients;

    public function __construct()
    {
        $this->dateCreate = new \DateTime();
        $this->clients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Bonus
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): BonusTypeEnum
    {
        return $this->type;
    }

    public function setType(BonusTypeEnum $type): Bonus
    {
        $this->type = $type;

        return $this;
    }
}
