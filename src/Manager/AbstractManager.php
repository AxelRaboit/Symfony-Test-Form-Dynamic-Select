<?php

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;

class AbstractManager
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    protected function save(object $entity): void
    {
        $this->em->persist($entity);
        $this->em->flush();
    }
}