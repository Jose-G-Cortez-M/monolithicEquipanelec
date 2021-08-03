<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Project;
use App\Entity\Task;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contractnumber')
            ->add('name')
            ->add('registrationdate',DateType::class,[
                'input' => 'datetime',
                'widget' => 'single_text',
            ])
            ->add('startdate')
            ->add('endtime')
            ->add('description')
            ->add('advances')
            ->add('totalcost')
            ->add('clients', EntityType::class,[
                'class' => Client::class,
                'choice_label' => 'representative'
            ])
            ->add('users', EntityType::class, array(
                        'class' => User::class,
                        'choice_label' => 'name',
                        'multiple' => true,
                        'expanded' => true
            ))
            ->add('tasks', EntityType::class, array(
                        'class' => Task::class,
                        'choice_label' => 'name',
                        'multiple' => true,
                        'expanded' => true,
                        'disabled' => true
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
