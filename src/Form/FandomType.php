<?php

namespace App\Form;

use App\Entity\Fandom;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\UX\Dropzone\Form\DropzoneType;

class FandomType extends AbstractType
{
    private string $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'name'
            ])
            ->add('image', FileType::class, [
                'required' => false,
                'label' => 'image',
                'attr' => [
                    'placeholder' => 'image',
                ]
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success '
                ]
            ]);
        $builder->get('image')->addModelTransformer(new CallBackTransformer(
            function ($imageUrl) {
                return null;
            },
            function ($imageUrl) {
                return $imageUrl;
            }
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Fandom::class,
        ));
    }
}