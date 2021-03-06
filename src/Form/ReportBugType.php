<?php

namespace App\Form;

use App\Entity\ReportBug;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReportBugType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('object_report', ChoiceType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control'
                ],
                'choices' => [
                    'Bug' => 'bug',
                    'Amélioration' => 'update'
                ]
            ])
            ->add('body_report', TextareaType::class, [
                'label' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReportBug::class,
        ]);
    }
}
