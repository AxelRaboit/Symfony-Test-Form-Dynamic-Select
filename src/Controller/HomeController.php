<?php

namespace App\Controller;

use App\Form\IssueType;
use App\Form\Model\IssueFormData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
        $issueFormData = new IssueFormData();
        $form = $this->createForm(IssueType::class, $issueFormData);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            dd($data);
        }

        return $this->render('home.html.twig', compact('form'));
    }
}
