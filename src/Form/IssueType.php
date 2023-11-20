<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Country;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class IssueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
                'disabled' => false,
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
