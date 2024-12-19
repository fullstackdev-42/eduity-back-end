<?php

namespace App\Form\Admin\Internal\Blog;

use App\Entity\Internal\Blog\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('slug')
            ->add('content')
            ->add('updatedOn')
            ->add('createdOn')
            ->add('deletedOn')
            ->add('author')
            ->add('createdBy')
            ->add('updatedBy')
            ->add('tags')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
