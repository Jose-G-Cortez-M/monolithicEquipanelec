<?php

namespace App\Form;

use App\Entity\Cable;
use App\Entity\Material;
use App\Entity\Movement;
use App\Entity\Project;
use App\Entity\Tool;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orderdate')
            ->add('quantity')
            ->add('tools',EntityType::class,[
                'class' => Tool::class,
                'choice_label' => 'name'
            ])
            ->add('materials', EntityType::class,[
                'class' => Material::class,
                'choice_label' => 'name'
            ])
            ->add('cables',EntityType::class,[
                'class' => Cable::class,
                'choice_label' => 'name',
                'placeholder' => 'Cables'
    ])
            ->add('projects',EntityType::class,[
                'class' => Project::class,
                'choice_label' => 'name'
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
