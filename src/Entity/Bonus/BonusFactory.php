<?php

declare(strict_types=1);

namespace App\Entity\Bonus;

use App\Enum\Bonus\BonusTypeEnum;

class BonusFactory
{
    public const TEST_BONUS_SMILE_NAME = 'test_bonus_smile';
    public const TEST_BONUS_HUG_NAME = 'test_bonus_hug';
    public const TEST_BONUS_FOR_DELETE_NAME = 'test_bonus_delete';

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
