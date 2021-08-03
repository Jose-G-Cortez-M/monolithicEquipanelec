<?php

namespace App\Form;

use App\Entity\Material;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('barcode',TextType::class,[
                'label' => "Enter the barcode",
                'required' => false
            ])
            ->add('name',TextType::class,[
                'label' => "Enter the name",
            ])
            ->add('stock',NumberType::class,[
                'label' => "Enter the number of materials you want to add to inventory",
            ])
            ->add('location')
            ->add('description',TextareaType::class,[
                'label' => "Enter a description of the material",
                'required' => false
            ])
            ->add('brand')
            ->add('purchasePrice',NumberType::class,[
                'label' => "Enter the entry price of the material",
            ])
            ->add('salePrice',NumberType::class,[
                'label' => "Enter the price at which you sell or charge the material",
            ])
            ->add('minimumLimit',NumberType::class,[
                'label' => "Enter the minimum quantity of material you want in the warehouse",
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
