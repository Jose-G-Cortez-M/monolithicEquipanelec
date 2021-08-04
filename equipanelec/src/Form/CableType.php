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
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', VichImageType::class,[
                'required' => false
            ])
            ->add('barcode', TextType::class,[
                'label' => "Enter the barcode",
                'required' => false
            ])
            ->add('name', TextType::class,[
                'label' => "Enter the name",
            ])
            ->add('availability',NumberType::class,[
                'label' => "Enter the meters of cable you want to add to inventory",
            ])
            ->add('weightPerMeter',NumberType::class,[
                'label' => "Enter the weight per meter of the cable",
                'required' => false
            ])
            ->add('purchasePrice',NumberType::class,[
                'label' => "Enter the entry price of the cable",
            ])
            ->add('salePrice',NumberType::class,[
                'label' => "Enter the price at which you sell or charge the cable",
            ])
            ->add('minimumLimit',NumberType::class,[
                'label' => "Enter the minimum quantity of cable you want in the warehouse",
                'required' => false
            ])
            ->add('location', TextareaType::class,[
                'label' => "Enter the location of the cable within the warehouse",
                'required' => false
            ])
            ->add('description', TextareaType::class,[
                'label' => "Enter a description of the cable",
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
