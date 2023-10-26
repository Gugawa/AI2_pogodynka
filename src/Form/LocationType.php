<?php

namespace App\Form;

use App\Entity\Location;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', null, [
                'attr' => [
                    'placeholder' => 'Nazwa miasta'
                ]
            ])
            ->add('country', ChoiceType::class, [
                'choices' => [
                    '(wybierz)' => null,
                    'Polska' => 'PL',
                    'Niemcy' => 'DE',
                    'Francja' => 'FR',
                    'Włochy' => 'IT',
                    'USA' => 'US',
                    'Wielka Brytania' => 'GB',
                ]
            ])
            ->add('latitude', NumberType::class , [
                'attr' => [
                    'type' => 'number',
                    'scale' => 7,
                ]
            ])
            ->add('longitude', NumberType::class , [
                'attr' => [
                    'type' => 'number',
                    'scale' => 7,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
