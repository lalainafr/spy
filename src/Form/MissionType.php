<?php

namespace App\Form;

use App\Entity\Agent;
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
                'label' => 'Liste des agents',
                'choice_label' => 'firstName',
                'class' => Agent::class,
                'multiple' => true,
                'expanded' => true
            ])
            ->add('speciality', EntityType::class, [
                'label' => 'Specialité',
                'choice_label' => 'name',
                'class' => Speciality::class,
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
