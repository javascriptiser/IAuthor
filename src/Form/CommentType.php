<?php

namespace App\Form;

use App\Entity\Comments;
use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', TextareaType::class, [
                'label' => 'Твой комментарий к главе',
                'attr' => [
                    'placeholder' => 'Оставить комментарий'
                ]])
            ->add('comment_confirm', SubmitType::class, ['label' => 'Добавить']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Comments::class,
        ));
    }
}