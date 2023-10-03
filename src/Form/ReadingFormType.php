<?php

namespace App\Form;

use App\Entity\Reading;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReadingFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('year', NumberType::class, [
                'mapped' => false,
                'label' => 'Año',
                'required' => true,
                'attr'=>[
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('variety', TextType::class, [
                'mapped' => false,
                'label' => 'Variedad',
                'required' => true,
                'attr'=>[
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('type', TextType::class, [
                'mapped' => false,
                'label' => 'Tipo',
                'required' => true,
                'attr'=>[
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('color', TextType::class, [
                'mapped' => false,
                'label' => 'Color',
                'required' => true,
                'attr'=>[
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('temperature', NumberType::class, [
                'mapped' => false,
                'label' => 'Temperatura',
                'required' => true,
                'attr'=>[
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('graduation', NumberType::class, [
                'mapped' => false,
                'label' => 'Graduación',
                'required' => true,
                'attr'=>[
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('ph', NumberType::class, [
                'mapped' => false,
                'label' => 'PH',
                'required' => true,
                'attr'=>[
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('observaciones', TextType::class, [
                'mapped' => false,
                'label' => 'Observaciones',
                'required' => false,
                'attr'=>[
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reading::class,
        ]);
    }
}
