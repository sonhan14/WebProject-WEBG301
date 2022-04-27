<?php

namespace App\Form;


use App\Entity\Grade;
use App\Entity\Course;
use App\Entity\Student;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class GradeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('student', EntityType::class,
            [
                'label' => 'Select the student name',
                'class' => Student::class,
                'required' => true,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('course', EntityType::class,
            [
                'label' => 'Select the student name',
                'class' => Course::class,
                'required' => true,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('grade', TextType::class,
            [
                'label' => 'Grade',
                'required' => true
            ])
            ->add('save', SubmitType::class,
            [
                'label' => 'Save'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Grade::class,
        ]);
    }
}
