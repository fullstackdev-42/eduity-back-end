<?php

namespace App\Form\User;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('plainPassword', Type\RepeatedType::class, [
                'type' => Type\PasswordType::class,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
                'required' => false
            ])
            ->add('firstName')
            ->add('lastName')
            ->add('avatar', UserAvatarType::class, [
                'label' => ' '
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
