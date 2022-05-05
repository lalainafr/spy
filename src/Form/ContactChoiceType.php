<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\Country;
use App\Entity\Hideout;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContactChoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        // Un formulaire pour servir de filtre le contact choisi dans la liste
        $builder
            ->add('contact', EntityType::class, [
                'label' => 'Choisir un contact',
                'class' => Contact::class,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
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
