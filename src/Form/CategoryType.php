<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('lead_category', ChoiceType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control mb-3'
                ],
                'choices' => array(
                    'No show' => 'NO_SHOW',
                    'Touriste Intéréssant' => 'INTERESTED',
                    'Touriste total' => 'TOTAL',
                    'Touriste prix' => 'PRICE',
                    'Touriste social' => 'SOCIAL',                        
                    'Paumé' => 'PALM',
                    'Chaud mais fauché' => 'BROKE',
                    'Chaud mais débordé' => 'NO_TIME',
                    'Chaud mais pas qualifié' => 'NO_QUALIFIED',
                    'Closé' => 'CLOSED'
                )
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
