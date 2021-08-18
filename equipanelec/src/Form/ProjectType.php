<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Project;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
                'label' => "Ingrese el número de contrato",
            ])
            ->add('name', TextType::class, [
                'label' => "Ingrese el nombre del representante para el proyecto",
            ])
            ->add('startDate', DateType::class, [
                'input' => 'datetime',
                'widget' => 'single_text',
                'required' => false,
                'label' => 'Fecha de inicio del proyecto'
            ])
            ->add('endTime', DateType::class, [
                'input' => 'datetime',
                'widget' => 'single_text',
                'required' => false,
                'label' => 'Fecha de finalización del proyecto'
            ])
            ->add('description', TextareaType::class, [
                'label' => "Ingrese una descripción o lista de materiales",
                'required' => false
            ])
            ->add('clients', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'representative',
                'placeholder' => 'Elije el cliente',
                'label' => "Elija el cliente que contrató el servicio"
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
