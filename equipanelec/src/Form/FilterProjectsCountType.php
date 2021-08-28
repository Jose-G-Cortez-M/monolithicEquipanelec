<?php

namespace App\Form;


use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class FilterProjectsCountType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    )
    {
        $builder
            ->add('startDate', DateType::class, [
                'input' => 'datetime',
                'widget' => 'single_text',
                'required' => true,
                'label' => 'Fecha de inicio'
            ])
            ->add('endTime', DateType::class, [
                'input' => 'datetime',
                'widget' => 'single_text',
                'required' => true,
                'label' => 'Fecha final'
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