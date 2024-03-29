<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

trait ActionDateTrait
{
    #[ORM\Column]
    private ?\DateTime $dateCreate = null;

    #[Groups(['api_response'])]
    public function getDateCreate(): \DateTime
    {
        return $this->dateCreate;
    }

    #[ORM\PrePersist]
    public function updateDateCreate(): void
    {
        if (!$this->dateCreate) {
            $this->dateCreate = new \DateTime('now');
        }
    }
}
