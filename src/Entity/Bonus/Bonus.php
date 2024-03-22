<?php

declare(strict_types=1);

namespace App\Entity\Bonus;

use App\Entity\ClientBonus\ClientBonus;
use App\Entity\Traits\ActionDateTrait;
use App\Enum\Bonus\BonusTypeEnum;
use App\Repository\Bonus\BonusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BonusRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Bonus implements \JsonSerializable
{
    use ActionDateTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['api_response'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[OA\Property(type: 'string', maxLength: 255)]
    #[Groups(['api_response'])]
    private string $name;

    #[ORM\Column(type: 'string', enumType: BonusTypeEnum::class)]
    #[Groups(['api_response'])]
    private BonusTypeEnum $type;

    #[ORM\OneToMany(targetEntity: ClientBonus::class, mappedBy: 'bonus')]
    private Collection $clients;

    public function __construct()
    {
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

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'type' => $this->getType()->value,
            'dateCreate' => $this->getDateCreate()->format('c'),
        ];
    }

    public function __toString(): string
    {
        return (string) $this->getId();
    }
}
