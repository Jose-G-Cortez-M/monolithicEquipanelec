<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TaskType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    )
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Ingrese el nombre de la tarea",
            ])
            ->add('timePerMinute', NumberType::class, [
                'label' => "Ingrese el tiempo en minutos que se tarda en completar la tarea",
            ])
            ->add('description', TextareaType::class, [
                'label' => "Ingrese una descripción de lo que se debe hacer en la tarea",
                'required' => false
            ])
            ->add('costPerTask', NumberType::class, [
                'label' => "Ingrese el costo de la tarea",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
