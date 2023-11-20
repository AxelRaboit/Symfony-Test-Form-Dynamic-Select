<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Country;
use App\Entity\Issue;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

class IssueFormType extends AbstractType
{
    public function __construct(private readonly CityRepository $cityRepository)
    {
    }

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
                'choice_label' => (function (Country $country) {
                    return $country->getId() . ' - ' . $country->getName();
                }),
                'query_builder' => function (CountryRepository $countryRepository) {
                    return $countryRepository->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
            ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'rows' => 5,
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Please enter your message']),
                    new Length(['min' => 10]),
                ],
            ]);

        $formModifier = function (FormInterface $form, Country $country = null) {
            $cities = $country == null ? [] : $this->cityRepository->findByCountry($country);

            $form->add('city', EntityType::Class, [
                'placeholder' => 'Select a city',
                'required' => true,
                'class' => City::class,
                'disabled' => $country == null,
                'choice_label' => 'name',
                'choices' => $cities,
            ]);
        };

        // This is used to set the initial value of the city field
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
            $data = $event->getData();
            $formModifier($event->getForm(), $data->getCountry());
        });

        // This is used to update the city field when the country field is changed
        /* POST_SUBMIT means that this event is triggered after the form is submitted
        (the form is only equal to the field that triggered the event, not the whole form) */
        $builder->get('country')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $country = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $country);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Issue::class
        ]);
    }
}
