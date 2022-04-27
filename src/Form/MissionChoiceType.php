<?php

namespace App\Form;

use App\Entity\Mission;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionChoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        // Un formulaire pour servir de filtre la mission choisie dans la liste
        $builder
            ->add('mission', EntityType::class, [
                'label' => 'Choisir une mission',
                'class' => Mission::class,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Validez',
                'attr' => [
                    'choice_label' => 'title',
                    'class' => 'btn btn-block btn-info'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
