<?php

namespace App\Entity\Bonus;

use App\Enum\Bonus\BonusTypeEnum;

class BonusFactory
{
    public static function create(?string $name = null, ?BonusTypeEnum $type = null): Bonus
    {
        $bonus = new Bonus();

        if ($name) {
            $bonus->setName($name);
        }

        if ($type) {
            $bonus->setType($type);
        }

        return $bonus;
    }
}
