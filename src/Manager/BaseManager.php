<?php

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;

class BaseManager
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {}

    public function save(object $entity): ?object
    {
        try {
            $this->em->persist($entity);
            $this->em->flush();

            return $entity;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function update(object $entity): ?object
    {
        try {
            $this->em->flush();

            return $entity;
        } catch (\Exception $e) {
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
            return null;
        }
    }
}
