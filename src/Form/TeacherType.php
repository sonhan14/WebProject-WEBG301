<?php

namespace App\Form;

use App\Entity\Teacher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TeacherRepository;
use Doctrine\Persistence\ManagerRegistry;


class TeacherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,
            [
                'label' => 'Name of teacher',
                'required' => true
            ])
            ->add('birthDay', DateType::class,
            [
                'label' => 'Birthday',
                'required' => true,
                'widget' => 'single_text'
            ])
            ->add('email', TextType::class,
            [
                'label' => 'email',
                'required' => true,
                
            ])
            ->add('Save',SubmitType::class)
        ;
    }

    #[Route('/delete_{id}', name: 'delete_teacher')]
    public function teacherDelete($id, ManagerRegistry $managerRegistry)
    {
        $teacher = $this->getDoctrine()->getRe
    }




    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Teacher::class,
        ]);
    }
}
