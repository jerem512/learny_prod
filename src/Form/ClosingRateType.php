<?php

namespace App\Form;

use App\Entity\ClosingRate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClosingRateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                'label' => false,
                'widget' => 'single_text',
                'disabled' => false
            ])
            ->add('fup', NumberType::class, [
                'label' => false,
            ])
            ->add('shofup', TextType::class, [
                'label' => false
            ])
            ->add('back', TextType::class, [
                'label' => false
            ])
            ->add('closefup', TextType::class, [
                'label' => false
            ])
            ->add('leads', TextType::class, [
                'label' => false
            ])
            ->add('leads_valid', TextType::class, [
                'label' => false
            ])
            ->add('leads_contact', TextType::class, [
                'label' => false
            ])
            ->add('leads_offer', TextType::class, [
                'label' => false
            ])
            ->add('leads_fup', TextType::class, [
                'label' => false
            ])
            ->add('leads_close', TextType::class, [
                'label' => false
            ])
            ->add('leads_confirm', TextType::class, [
                'label' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ClosingRate::class,
        ]);
    }
}
