<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    )
    {
        $builder
            ->add('company', TextType::class, [
                'label' => "Ingrese el nombre de la empresa",
            ])
            ->add('representative', TextType::class, [
                'label' => "Ingrese el nombre de un representante"
            ])
            ->add('phone', TextType::class, [
                'label' => "Ingrese un número de teléfono donde se pueda ubicar al representante de la compañía"
            ])
            ->add('direction', TextType::class, [
                'label' => "Ingrese la dirección de la empresa"
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
