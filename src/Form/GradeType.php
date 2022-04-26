<?php

namespace App\Form;


use App\Entity\Grade;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class GradeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('studentName', TextType::class,
            [
                'label' => 'Student Name',
                'required' => true
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
