<?php

namespace App\Repository\ClientBonus;

use App\Entity\Client\Client;
use App\Entity\ClientBonus\ClientBonus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ClientBonusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClientBonus::class);
    }

    public function getBonusesByClient(Client $client): array
    {
        $qb = $this->createQueryBuilder('cb');
        $e = $qb->expr();

        return $qb
            ->join('cb.bonus', 'b')
            ->where($e->eq('cb.client', ':client'))
            ->setParameter('client', $client->getId())
            ->getQuery()
            ->getResult();
    }
}
