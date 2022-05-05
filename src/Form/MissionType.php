<?php

namespace App\Form;

use App\Entity\Type;
use App\Entity\Agent;
use App\Entity\Status;
use App\Entity\Target;
use App\Entity\Contact;
use App\Entity\Country;
use App\Entity\Hideout;
use App\Entity\Mission;
use App\Entity\Speciality;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class MissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('agent', EntityType::class, [
                'label' => 'Agent(s)',
                'choice_label' => 'fullName',
                'placeholder' => 'Choisir un agent',
                'class' => Agent::class,
                'multiple' => true,
                'expanded' => true
            ])
            ->add('speciality', EntityType::class, [
                'label' => 'Specialité',
                'placeholder' => 'Choisir une spécialité',
                'choice_label' => 'name',
                'class' => Speciality::class,
            ])
            ->add('target', EntityType::class, [
                'label' => 'Cible(s)',
                'placeholder' => 'Choisir une cible',
                'choice_label' => 'fullName',
                'class' => Target::class,
                'multiple' => true,
                'expanded' => true
            ])
            ->add('hideout', EntityType::class, [
                'label' => 'Planque(s)',
                'placeholder' => 'Choisir une planque',
                'class' => Hideout::class,
                'multiple' => true,
                'expanded' => true
            ])
            ->add('type', EntityType::class, [
                'label' => 'Type',
                'placeholder' => 'Choisir un type de mission',
                'choice_label' => 'name',
                'class' => Type::class,
            ])
            ->add('status', EntityType::class, [
                'label' => 'Statut',
                'placeholder' => 'Choisir un statut de mission',
                'choice_label' => 'name',
                'class' => Status::class,
            ])
            ->add('country', EntityType::class, [
                'label' => 'Pays',
                'placeholder' => 'Choisir un Pays pour la mission',
                'choice_label' => 'name',
                'class' => Country::class,
            ])
            ->add('contact', EntityType::class, [
                'label' => 'Contact(s)',
                'placeholder' => 'Choisir un contact pour la mission',
                'class' => Contact::class,
                'multiple' => true,
                'expanded' => true
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
            'data_class' => Mission::class,
        ]);
    }
}
