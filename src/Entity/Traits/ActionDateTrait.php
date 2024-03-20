<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait ActionDateTrait
{
    #[ORM\Column]
    private ?\DateTime $dateCreate = null;

    public function getDateCreate(): \DateTime
    {
        return $this->dateCreate;
    }

    public function getFormattedCreateDate(): string
    {
        return $this->dateCreate->format('d.m.Y H:i');
    }

    #[ORM\PrePersist]
    public function updateDateCreate(): void
    {
        if (!$this->dateCreate) {
            $this->dateCreate = new \DateTime('now');
        }
    }
}
