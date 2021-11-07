<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Character;
use App\Entity\Fandom;
use App\Entity\MpaaRating;
use App\Entity\Status;
use App\Entity\Story;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class StoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'Title'
            ])
            ->add('description', TextType::class, [
                'required' => true,
                'label' => 'Description'
            ])
            ->add('mpaaRating', EntityType::class, [
                'class' => MpaaRating::class,
                'choice_label' => 'name',
                'label' => 'Mpaa Rating'
            ])
            ->add('authorsNote', TextType::class, [
                'required' => true,
                'label' => 'Authors Note'
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Category'
            ])
            ->add('fandom', EntityType::class, [
                'class' => Fandom::class,
                'choice_label' => 'name',
                'label' => 'Fandom'
            ])
            ->add('status', EntityType::class, [
                'class' => Status::class,
                'choice_label' => 'name',
                'label' => 'Status'
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'name',
                'multiple' => true,
                'label' => 'Tags'
            ])
            ->add('characters', EntityType::class, [
                'class' => Character::class,
                'choice_label' => 'name',
                'multiple' => true,
                'label' => 'Characters'
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success '
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Story::class,
        ));
    }
}