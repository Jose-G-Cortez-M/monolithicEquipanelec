<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('timePerMinute')
            ->add('description')
            ->add('costPerTask')
            ->add('projects', EntityType::class,[
                    'class' =>Project::class,
                    'choice_label' => 'name',
                    'multiple' => true,
                    'expanded' => true
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
