<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Country;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class)
            ->add('country', EntityType::Class, [
                'class' => Country::class,
                'choice_label' => 'name',
            ])
            ->add('city', EntityType::Class, [
                'class' => City::class,
                'choice_label' => 'name',
            ])
            ->add('message', TextareaType::class)
            ->getForm();

        return $this->render('home.html.twig', compact('form'));
    }
}
