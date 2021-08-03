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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orderdate',DateTimeType::class,[
                'disabled' => true,
                'widget' => 'single_text',
            ])
            ->add('quantity')
            ->add('tools',EntityType::class,[
                'class' => Tool::class,
                'choice_label' => 'name',
                'placeholder' => 'Selecciona un herramienta',
                'required' => false,
                'disabled' => true
            ])
            ->add('materials', EntityType::class,[
                'class' => Material::class,
                'choice_label' => 'name',
                'placeholder' => 'Selecciona un Material',
                'required' => false,
                'disabled' => true
            ])
            ->add('cables',EntityType::class,[
                'class' => Cable::class,
                'choice_label' => 'name',
                'placeholder' => 'Selecciona un Cable',
                'required' => false,
                'disabled' => true
            ])
            ->add('projects',EntityType::class,[
                'class' => Project::class,
                'choice_label' => 'name',
                'placeholder' => 'Selecciona un Proyecto',
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
