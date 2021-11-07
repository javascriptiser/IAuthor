<?php

namespace App\Form;

use App\Entity\Parts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'title'
            ])
            ->add('text', TextType::class, [
                'required' => true,
                'label' => 'text'
            ])
            ->add('commentBeforePart', TextType::class, [
                'required' => true,
                'label' => 'Comment before'
            ])->add('commentAfterPart', TextType::class, [
                'required' => true,
                'label' => 'Comment after'
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success '
                ]
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Parts::class,
        ));
    }
}