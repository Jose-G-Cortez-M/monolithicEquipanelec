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
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', VichImageType::class)
            ->add('barcode', TextType::class, [
                'label' => "Enter the barcode",
                'required' => false
            ])
            ->add('name', TextType::class, [
                'label' => "Enter the name",
            ])
            ->add('stock', NumberType::class, [
                'label' => "Enter the number of materials you want to add to inventory",
            ])
            ->add('brand', TextType::class, [
                'label' => "Enter the brand of the material",
                'required' => false
            ])
            ->add('purchasePrice', NumberType::class, [
                'label' => "Enter the entry price of the material",
            ])
            ->add('salePrice', NumberType::class, [
                'label' => "Enter the price at which you sell or charge the material",
            ])
            ->add('minimumLimit', NumberType::class, [
                'label' => "Enter the minimum quantity of material you want in the warehouse",
                'required' => false
            ])
            ->add('location', TextareaType::class, [
                'label' => "Enter the location of the material within the warehouse",
                'required' => false
            ])
            ->add('description', TextareaType::class, [
                'label' => "Enter a description of the material",
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
