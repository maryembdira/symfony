<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Author;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('publicationDate', DateType::class, [
                'label' => 'Publication date',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('category', ChoiceType::class, [
                'label' => 'Category',
                'choices' => [
                    'Mystery' => 'Mystery',
                    'Science Fiction' => 'Science Fiction',
                    'Horror' => 'Horror',
                ],
                'placeholder' => 'Choose a category',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'username', // uses username for dropdown
                'label' => 'Author',
                'placeholder' => 'Select an author',
                'attr' => ['class' => 'form-control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
