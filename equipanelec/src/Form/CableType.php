<?php

namespace App\Form;

use App\Entity\Cable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CableType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    )
    {
        $builder
            ->add('imageFile', VichImageType::class)
            ->add('barcode', TextType::class, [
                'label' => "Ingrese el código de barras",
                'required' => false
            ])
            ->add('name', TextType::class, [
                'label' => "Ingrese el nombre",
            ])
            ->add('availability', NumberType::class, [
                'label' => "Ingrese los metros de cable que desea agregar al inventario",
            ])
            ->add('weightPerMeter', NumberType::class, [
                'label' => "Ingrese el peso por metro del cable",
                'required' => false
            ])
            ->add('purchasePrice', NumberType::class, [
                'label' => "Ingrese el precio de entrada del cable por metro",
            ])
            ->add('salePrice', NumberType::class, [
                'label' => "Ingrese el precio al que vende el cable por metro",
            ])
            ->add('minimumLimit', NumberType::class, [
                'label' => "Ingrese la cantidad mínima de cable que desea en el almacén",
                'required' => false
            ])
            ->add('location', TextareaType::class, [
                'label' => "Ingrese la ubicación del cable dentro del almacén",
                'required' => false
            ])
            ->add('description', TextareaType::class, [
                'label' => "Ingrese una descripción del cable",
                'required' => false
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cable::class,
        ]);
    }
}
