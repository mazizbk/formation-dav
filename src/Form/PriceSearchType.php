<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $dataOptionComArmName = isset($options['data']) ? array_column($options['data'], 'com_arm_name', 'com_arm_name') : [];
        $dataOptionAdresse = isset($options['data']) ? array_column($options['data'], 'adresse', 'adresse') : [];
        $dataOptionTypeFuel = isset($options['data']) ? array_column($options['data'], 'prix_nom', 'prix_nom') : [];

        $builder

            ->add('com_arm_name', ChoiceType::class, [
                'label' => 'Arrondissement',
                'placeholder' => '-- Choisir un arrondissement --',
                'choices' => $dataOptionComArmName,
                'required' => false
            ])
            ->add('adresse', ChoiceType::class, [
                'label' => 'Station',
                'placeholder' => '-- Choisir une station --',
                'choices' => $dataOptionAdresse,
                'required' => false
            ])
            ->add('prix_nom', ChoiceType::class, [
                'label' => 'Energie',
                'placeholder' => '-- Choisir une energie --',
                'choices' => $dataOptionTypeFuel,
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
