<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Country;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Please enter your name']),
                    new Length(['min' => 3]),
                ],
            ])
            ->add('country', EntityType::Class, [
                'constraints' => [
                    new NotBlank(['message' => 'Please select a country']),
                ],
                'placeholder' => 'Select a country',
                'class' => Country::class,
                'choice_label' => (function(Country $country) {
                    return $country->getId() . ' - ' . $country->getName();
                }),
                'query_builder' => function(CountryRepository $countryRepository) {
                    return $countryRepository->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
            ])
            ->add('city', EntityType::Class, [
                'constraints' => [
                    new NotBlank(['message' => 'Please select a city']),
                ],
                'placeholder' => 'Select a city',
                'disabled' => true,
                'class' => City::class,
                'choice_label' => 'name',
                'query_builder' => function(CityRepository $cityRepository) {
                    return $cityRepository->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
            ])
            ->add('message', TextareaType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Please enter your message']),
                    new Length(['min' => 10]),
                ],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            dd($data);
        }

        return $this->render('home.html.twig', compact('form'));
    }
}
