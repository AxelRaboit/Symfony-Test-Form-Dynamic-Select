<?php

namespace App\Manager;

use App\Entity\Issue;
use Doctrine\ORM\EntityManagerInterface;

class IssueManager
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function save(Issue $issue): void
    {
        $this->em->persist($issue);
        $this->em->flush();
    }
}