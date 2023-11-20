<?php

namespace App\Controller;

use App\Entity\Issue;
use App\Form\IssueFormType;
use App\Repository\CountryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $issue = new Issue();

        $form = $this->createForm(IssueFormType::class, $issue);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($issue);
            $em->flush();

            $this->addFlash('success', 'Your issue has been submitted!');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('home.html.twig', compact('form'));
    }
}
