<?php

namespace App\Controller;

use App\Entity\Teacher;
use App\Form\TeacherType;
use App\Repository\TeacherRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class TeacherController extends AbstractController
{
    #[Route('/teacher', name: 'teacher')]
    public function index(): Response
    {
        $teachers =$this->getDoctrine()->getRepository(Teacher::class)->findAll();

        return $this->render('teacher/index.html.twig', [
            'Teachers' => $teachers,
        ]);
    }

    #[Route('/add', name: 'add_teacher')]
    public function add(Request $request, ManagerRegistry $managerRegistry)
    {
        $teacher = new Teacher();
        $form = $this->createForm(TeacherType::class, $teacher);
        //yêu cầu xử lý form 
        $form -> handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($teacher);
            $manager->flush();
            $this->addFlash("Success", "Teacher added successfully !");
            return $this->redirectToRoute("teacher");
        }
        return $this->renderForm(
            'teacher/add.html.twig',
            [
                'teacherForm' => $form
            ]
        );
    }


}
