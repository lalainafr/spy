<?php

namespace App\Form;

use App\Entity\Agent;
use App\Entity\Country;
use App\Entity\Speciality;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class AgentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('brithDate', DateTimeType::class, ['widget' => 'single_text'])
            ->add('speciality', EntityType::class, [
                'class' => Speciality::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisir la nationalité'
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
            'data_class' => Agent::class,
        ]);
    }
}
