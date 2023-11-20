<?php

namespace App\Controller;

use App\Entity\Issue;
use App\Form\IssueFormType;
use App\Manager\IssueManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, IssueManager $issueManager): Response
    {
        $issue = new Issue();

        $form = $this->createForm(IssueFormType::class, $issue);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $issueManager->save($issue);

            $this->addFlash('success', 'Your issue has been submitted!');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('home.html.twig', compact('form'));
    }
}
