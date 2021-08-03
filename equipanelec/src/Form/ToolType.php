<?php

namespace App\Form;

use App\Entity\Tool;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ToolType extends AbstractType
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
                'label' => "Enter the number of tools you want to add to inventory",
            ])
            ->add('brand',TextType::class,[
                'label' => "Enter the brand of the material",
            ])
            ->add('price',NumberType::class,[
                'label' => "Enter the cost of the tool",
            ])
            ->add('description',TextareaType::class,[
                'label' => "Enter a description of the tool",
                'required' => false
            ])
            ->add('location',TextareaType::class,[
                'label' => "Enter the location of the tool within the warehouse",
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
