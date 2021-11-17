<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserCreateType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,[
                'required'=>true,
                'label'=>'Почта'
            ])
            ->add('image', FileType::class, [
                'required' => false,
                'data_class' => null,
                'label' => 'Изображение',
                'attr' => [
                    'placeholder' => 'Изображение'
                ]
            ])
            ->add('username', TextType::class,[
                'required'=>true,
                'label'=>'Имя пользователя'
            ])
            ->add('password', PasswordType::class,[
                'required'=>true,
                'label'=>'Пароль'
            ])
            ->add('Save', SubmitType::class,[
                'label'=>'Сохранить'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}