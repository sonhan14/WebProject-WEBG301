<?php

namespace App\Form;

use App\Entity\Major;
use App\Entity\Course;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Enter the course name',
                'required' => true,
                'attr' => [
                    'minlength' => 3,
                    'maxlength' => 30,
                ]
            ])
            ->add('description', TextType::class, [
                'label' => 'Enter the course description',
                'required' => true,
            ])
            ->add('timeStart', DateType::class,
            [
                'label' => 'Date',
                'required' => true,
                'widget' => 'single_text',
            ])
            ->add('timeEnd', DateType::class,
            [
                'label' => 'Date',
                'required' => true,
                'widget' => 'single_text',
                'constraints' => [
                    new Constraints\Callback([
                        'callback' => function ($date, ExecutionContextInterface $context) {
                            if ($date->getTimeStart() > $date->getTimeEnd()) {
                                $context->buildViolation('The end date must be after the start date')
                                    ->atPath('timeEnd')
                                    ->addViolation();
                            }
                        },
                    ]),
                ],

                
            ])
            ->add('image', TextType::class, [
                'label' => 'Enter the course image',
                'required' => true,
            ])
            ->add('major', EntityType::class, 
            [
                'label' => 'Select the course major',
                'class' => Major::class,
                'required' => true,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('Save', SubmitType::class)
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
