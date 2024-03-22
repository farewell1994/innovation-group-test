<?php

declare(strict_types=1);

namespace App\Repository\Bonus;

use App\Entity\Bonus\Bonus;
use App\Enum\Bonus\BonusTypeEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class BonusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bonus::class);
    }

    public function getSmileBonuses(): array
    {
        $qb = $this->createQueryBuilder('b');
        $e = $qb->expr();

        return $qb
            ->where($e->eq('b.type', ':smileType'))
            ->setParameter('smileType', BonusTypeEnum::SMILE)
            ->getQuery()
            ->getResult();
    }

    public function getHugBonuses(): array
    {
        $qb = $this->createQueryBuilder('b');
        $e = $qb->expr();

        return $qb
            ->andWhere($e->eq('b.type', ':hugType'))
            ->setParameter('hugType', BonusTypeEnum::HUG)
            ->getQuery()
            ->getResult();
    }

    public function getBonusesQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('b');
    }
}
