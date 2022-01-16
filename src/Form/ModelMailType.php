<?php

namespace App\Form;

use App\Entity\ModelMail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModelMailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false
            ])
            ->add('model_object', TextType::class, [
                'label' => false
            ])
            ->add('model_body', TextareaType::class, [
                'label' => false
            ])
            ->add('Type', ChoiceType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control'
                ],
                'choices'  => [
                    'Email Closing' => 'email',
                    'Premium' => 'premium',
                    'Accompagnement' => 'accompagnement',
                    'Mes mails' => 'own_mail'
                ],
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ModelMail::class,
        ]);
    }
}
