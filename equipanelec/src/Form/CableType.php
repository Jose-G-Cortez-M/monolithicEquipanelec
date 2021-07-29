<?php

namespace App\Form;

use App\Entity\Cable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('barcode')
            ->add('name')
            ->add('availablemeter')
            ->add('weightpermeter')
            ->add('purcharseprice')
            ->add('saleprice')
            ->add('description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cable::class,
        ]);
    }
}
