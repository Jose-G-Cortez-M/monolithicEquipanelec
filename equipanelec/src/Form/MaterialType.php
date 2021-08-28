<?php

namespace App\Form;

use App\Entity\Material;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class MaterialType extends AbstractType
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
            ->add('stock', NumberType::class, [
                'label' => "Ingrese la cantidad de materiales que desea agregar al inventario",
            ])
            ->add('brand', TextType::class, [
                'label' => "Ingrese la marca del material",
                'required' => false
            ])
            ->add('purchasePrice', NumberType::class, [
                'label' => "Ingrese el precio de entrada del material",
            ])
            ->add('salePrice', NumberType::class, [
                'label' => "Ingrese el precio al que vende el material",
            ])
            ->add('minimumLimit', NumberType::class, [
                'label' => "Ingrese la cantidad mínima de material que desea en el almacén",
                'required' => false
            ])
            ->add('location', TextareaType::class, [
                'label' => "Ingrese la ubicación del material dentro del almacén",
                'required' => false
            ])
            ->add('description', TextareaType::class, [
                'label' => "Ingrese una descripción del material",
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Material::class,
        ]);
    }
}
