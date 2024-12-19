<?php

namespace App\Form\Admin;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('roles')
            ->add('password')
            ->add('firstName')
            ->add('lastName')
            ->add('isLocked')
            ->add('lockExpirationDate')
            ->add('loginAttempts')
            ->add('lastLoginAttempt')
            ->add('isEmailConfirmed')
            ->add('emailConfirmationCode')
            ->add('resetPasswordCode')
            ->add('unlockCode')
            ->add('resetPasswordCodeExpirationDate')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
