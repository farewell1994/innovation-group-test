<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait ActionDateTrait
{
    #[ORM\Column]
    private \DateTime $dateCreate;

    public function getDateCreate(): \DateTime
    {
        return $this->dateCreate;
    }

    public function setDateCreate(\DateTime $dateCreate): self
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }
}
