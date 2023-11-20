<?php

namespace App\Controller;

use App\Repository\IssueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IssueController extends AbstractController
{
    #[Route('/issues', name: 'app_issue_list')]
    public function issues(IssueRepository $issueRepository): Response
    {
        return $this->render('issue/list.html.twig', [
            'issues' => $issueRepository->findAll()
        ]);
    }

    #[Route('/issue/{id}', name: 'app_issue_show')]
    public function issue(IssueRepository $issueRepository, int $id): Response
    {
        return $this->render('issue/show.html.twig', [
            'issue' => $issueRepository->find($id)
        ]);
    }
}
