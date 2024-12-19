<?php

namespace App\Form\Jobmap;

use App\Entity\Jobmap\Organization;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrganizationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('entityType')
            ->add('missionStatement')
            ->add('totalEmployees')
            ->add('financialYearEnds')
            ->add('naicsMajor')
            ->add('naicsMinor')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Organization::class,
        ]);
    }
}
