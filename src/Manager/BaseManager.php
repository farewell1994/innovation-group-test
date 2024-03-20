<?php

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class BaseManager
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly LoggerInterface $logger,
    ) {}

    public function save(object $entity): ?object
    {
        try {
            $this->em->persist($entity);
            $this->em->flush();

            return $entity;
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());

            return null;
        }
    }

    public function update(object $entity): ?object
    {
        try {
            $this->em->flush();

            return $entity;
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());

            return null;
        }
    }

    public function delete(object $entity): ?object
    {
        try {
            $this->em->remove($entity);
            $this->em->flush();

            return $entity;
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());

            return null;
        }
    }
}
