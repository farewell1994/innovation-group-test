<?php

declare(strict_types=1);

namespace App\Repository\ClientBonus;

use App\Entity\Client\Client;
use App\Entity\ClientBonus\ClientBonus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class ClientBonusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClientBonus::class);
    }

    public function getBonusesByClientQuery(Client $client): QueryBuilder
    {
        $qb = $this->createQueryBuilder('cb');
        $e = $qb->expr();

        return $qb
            ->join('cb.bonus', 'b')
            ->addSelect('b')
            ->where($e->eq('cb.client', ':client'))
            ->setParameter('client', $client->getId());
    }
}
