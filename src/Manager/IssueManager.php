<?php

namespace App\Manager;

use App\Entity\Issue;

class IssueManager extends AbstractManager
{
    public function handleSave(Issue $issue): void
    {
        $issue->setCreatedAt(new \DateTimeImmutable());
        $this->save($issue);
    }
}