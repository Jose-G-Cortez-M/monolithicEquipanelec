<?php

namespace App\Form;

use App\Entity\Cable;
use App\Entity\Material;
use App\Entity\Movement;
use App\Entity\Project;
use App\Entity\Tool;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orderDate', DateTimeType::class, [
                'disabled' => true,
                'widget' => 'single_text',
            ])
            ->add('quantity', NumberType::class, [
                'label' => "Enter here the number of elements you need in the movement.",
            ])
            ->add('tools', EntityType::class, [
                'class' => Tool::class,
                'choice_label' => 'name',
                'placeholder' => 'Select a tool',
                'required' => false,
                'disabled' => true
            ])
            ->add('materials', EntityType::class, [
                'class' => Material::class,
                'choice_label' => 'name',
                'placeholder' => 'Select a material',
                'required' => false,
                'disabled' => true
            ])
            ->add('cables', EntityType::class, [
                'class' => Cable::class,
                'choice_label' => 'name',
                'placeholder' => 'Select a cable',
                'required' => false,
                'disabled' => true
            ])
            ->add('projects', EntityType::class, [
                'class' => Project::class,
                'choice_label' => 'name',
                'placeholder' => 'Select a Project',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Movement::class,
        ]);
    }
}
