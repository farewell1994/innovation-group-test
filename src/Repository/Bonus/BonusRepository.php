<?php

declare(strict_types=1);

namespace App\Repository\Bonus;

use App\Entity\Bonus\Bonus;
use App\Entity\Client\Client;
use App\Entity\ClientBonus\ClientBonus;
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

    public function getBonusesQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('b');
    }

    public function getHugBonusesForClient(Client $client): array
    {
        return $this->getBonusesForClient($client, BonusTypeEnum::HUG);
    }

    public function getSmileBonusesForClient(Client $client): array
    {
        return $this->getBonusesForClient($client, BonusTypeEnum::SMILE);
    }

    private function getBonusesForClient(Client $client, BonusTypeEnum $bonusType): array
    {
        $qb = $this->createQueryBuilder('b');
        $e = $qb->expr();
        $existingClientBonusesSubQuery = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('_b.id')
            ->from(ClientBonus::class, 'cb')
            ->join('cb.bonus', '_b')
            ->where($e->eq('cb.client', ':client'))
            ->andWhere($e->eq('_b.type', ':bonusType'));

        return $qb
            ->where($e->eq('b.type', ':bonusType'))
            ->andWhere($e->notIn('b.id', $existingClientBonusesSubQuery->getDQL()))
            ->setParameter('bonusType', $bonusType)
            ->setParameter('client', $client)
            ->getQuery()
            ->getResult();
    }
}
