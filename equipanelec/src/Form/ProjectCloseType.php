<?php

namespace App\Form;

use App\Entity\ProjectClose;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectCloseType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    )
    {
        $builder
            ->add('contract_number')
            ->add('name')
            ->add('registration_date')
            ->add('totalCost')
            ->add('startDate')
            ->add('endTime')
            ->add('date')
            ->add('commercialValue')
            ->add('total_cost_task')
            ->add('total_cost_inventory')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProjectClose::class,
        ]);
    }
}
