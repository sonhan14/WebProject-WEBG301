<?php

namespace App\Form;

use App\Entity\Major;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MajorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, 
            [
                'label' => 'Major name',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Enter the major name',
                    'minlength' => 3,
                    'maxlength' => 30,]
            ])
            ->add('description', TextType::class,
            [
                'label' => 'Major description',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Enter the major description',
                ]
            ])
            ->add('image', TextType::class,
            [
                'label' => 'Major image',
                'required' => true,
            ])
            ->add('Save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Major::class,
        ]);
    }
}
