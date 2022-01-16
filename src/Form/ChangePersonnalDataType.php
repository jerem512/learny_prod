<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePersonnalDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image', FileType::class, [
                'label' => false,
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'id' => 'file',
                    'class' => 'file-upload'
                ]
            ])
            ->add('first_name', TextType::class, [
                'label' => false
            ])
            ->add('last_name', TextType::class, [
                'label' => false
            ])
            ->add('pseudo', TextType::class, [
                'label' => false
            ])
            ->add('city', TextType::class, [
                'label' => false
            ])
            ->add('birthdate', TextType::class, [
                'label' => false
            ])
            ->add('country', TextType::class, [
                'label' => false
            ])
            ->add('address', TextareaType::class, [
                'label' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
