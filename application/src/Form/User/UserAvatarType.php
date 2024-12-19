<?php

namespace App\Form\User;

use App\Entity\UploadedFile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Validator\Constraints\Image;

class UserAvatarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', Type\FileType::class, [
                'required' => false,
                'error_bubbling' => false,
                'attr' => [
                    'accept' => 'image/*',
                    'novalidate' => 'novalidate'
                ],
                'label' => 'Avatar Image',
                'constraints' => [
                    new Image([
                        'minWidth' => 100,
                        'maxWidth' => 400,
                        'minHeight' => 100,
                        'maxHeight' => 400,
                        'maxSize' => '250k'
                        ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UploadedFile::class,
        ]);
    }
}
