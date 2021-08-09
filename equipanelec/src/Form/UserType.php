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
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'Enter an email with which you can create your account'
            ])
            ->add('roles', ChoiceType::class, [
                    'multiple' => true,
                    'choices' => [
                        'Cellar manager' => 'ROLE_CELLAR',
                        'Project Manager' => 'ROLE_PROJECT_MANAGER',
                        'Counter' => 'ROLE_COUNTER',
                        'Workers' => 'ROLE_WORKERS',
                        'Administrator' => 'ROLE_MANAGER'
                    ]
            ])
            ->add('password', PasswordType::class, [
                'required' => true,
                'label' => "Enter a password"
            ])
            ->add('name', TextType::class, [
                'label' => "Enter the name of the employee",
            ])
            ->add('phone', TextType::class, [
                'label' => "Enter a contact phone",
            ])
            ->add('salary', NumberType::class, [
                'label' => "Enter the salary received by the employee",
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
