<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('roles',ChoiceType::class,[
                    'multiple' => true,
                    'choices' => [
                        'Encargado de la bodega' => 'ROLE_CELLAR',
                        'Jefe de proyectos' => 'ROLE_PROJECT_MANAGER',
                        'Contador' => 'ROLE_COUNTER',
                        'Obreros' => 'ROLE_WORKERS',
                        'Administrador' => 'ROLE_MANAGER'

                    ]
            ])
            ->add('password')
            ->add('name')
            ->add('phone')
            ->add('salary')
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
            'data_class' => User::class,
        ]);
    }
}
