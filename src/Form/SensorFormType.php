<?php

namespace App\Form;

use App\Entity\Sensor;
use App\Entity\SensorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SensorFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('value', TextType::class, [
                'mapped' => false,
                'label' => 'Valor',
                'required' => true,
                'attr'=>[
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('sensorType', EntityType::class, [
                'class' => SensorType::class,
                'multiple' => false,
                'choice_label' => 'name',
                'required' => true,
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
            'data_class' => Sensor::class,
        ]);
    }
}
