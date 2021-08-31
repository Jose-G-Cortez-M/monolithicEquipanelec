<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    )
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'Ingresa un correo electrónico'
            ])
            ->add('roles', ChoiceType::class, [
                    'multiple' => true,
                    'choices' => [
                        'Encargado de bodega' => 'ROLE_CELLAR',
                        'Jefe de proyectos' => 'ROLE_PROJECT_MANAGER',
                        'Contador' => 'ROLE_COUNTER',
                        'Trabajador' => 'ROLE_WORKERS',
                        'Administrador' => 'ROLE_MANAGER'
                    ],
                'label' => 'Seleccione el rol del empleado'
            ])
            ->add('password', PasswordType::class, [
                'required' => true,
                'label' => "Ingrese una contraseña para la cuenta"
            ])
            ->add('name', TextType::class, [
                'label' => "Ingrese el nombre del empleado",
            ])
            ->add('phone', TextType::class, [
                'label' => "Ingrese un teléfono de contacto",
            ])
            ->add('salary', NumberType::class, [
                'label' => "Ingrese el salario percibido por el empleado.",
            ])
            /*->add('projects', EntityType::class, [
                'class' =>Project::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Here you can assign an employee to a project'
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
