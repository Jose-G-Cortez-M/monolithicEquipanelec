<?php

namespace App\Form;

use App\Entity\Tool;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ToolType extends AbstractType
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
                'label' => "Ingrese la cantidad de herramientas que desea agregar al inventario",
            ])
            ->add('brand', TextType::class, [
                'label' => "Ingrese la marca de la herramienta",
                'required' => false
            ])
            ->add('price', NumberType::class, [
                'label' => "Ingrese el costo de la herramienta",
            ])
            ->add('minimumLimit', NumberType::class, [
                'label' => "Ingrese la cantidad mínima de herramientas que desea en el almacén",
                'required' => false
            ])
            ->add('location', TextareaType::class, [
                'label' => "Ingrese la ubicación de la herramienta dentro del almacén",
                'required' => false
            ])
            ->add('description', TextareaType::class, [
                'label' => "Ingrese una descripción de la herramienta",
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tool::class,
        ]);
    }
}
