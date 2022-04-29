<?php

namespace App\Form;

use App\Entity\Target;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TargetChoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        // Un formulaire pour servir de filtre le cible choisie dans la liste
        $builder
            ->add('target', EntityType::class, [
                'label' => 'Choisir un cible',
                'class' => Target::class,
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
