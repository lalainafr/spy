<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\Hideout;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class HideoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code')
            ->add('address')
            ->add('type')
            ->add('country', EntityType::class, [
                'label' => 'Nationalité',
                'class' => Country::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisir une nationalité'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Validez',
                'attr' => [
                    'class' => 'btn btn-block btn-info'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hideout::class,
        ]);
    }
}
