<?php

namespace App\Form;

use App\Entity\FeedBack;
use App\Entity\Teacher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FeedbackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('feedBack', TextType::class,
            [
                'label' => 'Feedback for teacher',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Enter the feedback',
                    'minlength' => 3,
                ]
            ])
            ->add('receivedAt', DateType::class,
            [
                'label' => 'Date',
                'required' => true,
                'widget' => 'single_text'
            ])
            ->add('teacher', EntityType::class,
            [
                'label' => "Choose the teacher",
                'class' => Teacher::class,
                'required' => true,
                'choice_label' => 'name',
                'multiple' =>false,
                'expanded' => false,
            ] )
            ->add('Save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FeedBack::class,
        ]);
    }
}
