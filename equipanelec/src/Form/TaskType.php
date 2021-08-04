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
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'label' => "Enter the task name",
            ])
            ->add('timePerMinute',NumberType::class,[
                'label' => "Enter the time in minutes it takes to complete the task",
            ])
            ->add('description',TextareaType::class,[
                'label' => "Enter a description of what should be done in the task",
                'required' => false
            ])
            ->add('costPerTask',NumberType::class,[
                'label' => "Enter the cost of the task",
            ])
            ->add('projects', EntityType::class,[
                    'class' =>Project::class,
                    'choice_label' => 'name',
                    'multiple' => true,
                    'expanded' => true,
                    'label' => "Choose the projects for which the task will be enabled"
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
