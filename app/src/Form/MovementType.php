<?php

namespace App\Form;

use App\Entity\Movement;
use App\Entity\Project;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovementType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    )
    {
        $builder
            ->add('orderDate', DateTimeType::class, [
                'disabled' => true,
                'widget' => 'single_text',
                'label' => 'Fecha de registro'
            ])
            ->add('quantity', NumberType::class, [
                'label' => "Ingrese la cantidad de elementos que necesita en el movimiento",
            ])
            ->add('description', TextareaType::class, [
                'label' => "Ingrese una descripción del material",
                'required' => false
            ])
            ->add('projects', EntityType::class, [
                'class' => Project::class,
                'choice_label' => 'name',
                'placeholder' => 'Seleccione un proyecto',
                'required' => false,
                'label' => 'Seleccione el proyecto al que se va asignar el articulo'
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
