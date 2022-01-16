<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => false
            ])
            ->add('last_name', TextType::class, [
                'label' => false
            ])
            ->add('first_name', TextType::class, [
                'label' => false
            ])
            ->add('roles', CollectionType::class, [
            
                'entry_type'   => ChoiceType::class,
                'label' => false,
            
                'entry_options'  => [
                    'required' => true,
                    'label' => false,
                    'placeholder' => 'Choisir un rôle',
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'choices' => [
                        'Closer' => 'ROLE_CLOSER',
                        'Admin' => 'ROLE_ADMIN',
                    ],
                ],
            ])
            ->add('ringover_phone_number', TextType::class, [
                'label' => false
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => 'Entrez votre mot de passe ...'
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Merci d\'entrer un mot de passe',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'La longueur du mot de passe doit dépasser {{ limit }} caractères.',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                    ],
                    'label' => false,
                ],
                'second_options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => 'Confirmez votre mot de passe'
                    ],
                    'label' => false,
                ],
                'invalid_message' => 'Les mots de passes doivent être identiques.',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => true,
            ])
            ->add('calendly_token', TextareaType::class, [
                'label' => false
            ])
            ->add('uuid_calendly', TextType::class, [
                'label' => false
            ])
            ->add('ringover_token', TextType::class, [
                'label' => false
            ])
            ->add('learnybox_token', TextType::class, [
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
