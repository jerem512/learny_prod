<?php

namespace App\Form;

use App\Entity\Close;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CloseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', ChoiceType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control mb-3'
                ],
                'choices' => array(
                    'Premium x1' => 'premium_x1',
                    'Premium x2' => 'premium_x2',
                    'Premium x3' => 'premium_x3',
                    'Premium x6' => 'premium_x6',
                    'Premium x12' => 'premium_x12',                        
                    'Accompagnement x1' => 'accompagnement_x1',
                    'Accompagnement x2' => 'accompagnement_x2',
                    'Accompagnement x3' => 'accompagnement_x3',
                    'Accompagnement x6' => 'accompagnement_x6',
                    'Accompagnement x12' => 'accompagnement_x12',
                    'CPF' => 'cpf'
                )
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Close::class,
        ]);
    }
}
