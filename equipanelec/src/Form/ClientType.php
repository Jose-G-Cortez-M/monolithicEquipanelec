<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('company',TextType::class,[
                'label' => "Enter the company name",
            ])
            ->add('representative', TextType::class,[
                'label' => "Enter the name of a representative"
            ])
            ->add('phone',TextType::class,[
                'label' => "Enter a name where the company representative can be located"
            ])
            ->add('direction',TextType::class,[
                'label' => "Enter the company address"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
