<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Project;
use App\Entity\Task;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contractNumber', TextType::class, [
                'label' => "Enter the contract number",
            ])
            ->add('name', TextType::class, [
                'label' => "Enter a representative name for the project",
            ])
            ->add('startDate', DateType::class, [
                'input' => 'datetime',
                'widget' => 'single_text',
                'required' => false,
                'label' => 'Project start date'
            ])
            ->add('endTime', DateType::class, [
                'input' => 'datetime',
                'widget' => 'single_text',
                'required' => false,
                'label' => 'Project end date'
            ])
            ->add('description', TextareaType::class, [
                'label' => "Enter a description or the List Materials of the project",
                'required' => false
            ])
            ->add('clients', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'representative',
                'placeholder' => 'Choose the client',
                'label' => "Choose the client who hired the service"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
