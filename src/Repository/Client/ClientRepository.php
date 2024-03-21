<?php

namespace App\Repository\Client;

use App\Entity\Client\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function getClientsQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('c');
    }

    public function getClientsWithBonusesQuery(int $clientId): ?Client
    {
        $qb = $this->createQueryBuilder('c');

        return $qb
            ->where($qb->expr()->eq('c.id', ':clientId'))
            ->setParameter('clientId', $clientId)
            ->leftJoin('c.clientBonuses', 'cb')
            ->leftJoin('cb.bonus', 'b')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
