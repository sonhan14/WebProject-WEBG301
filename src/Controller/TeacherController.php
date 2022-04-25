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

#[Route('/teacher')]


class TeacherController extends AbstractController
{
    
    #[Route('/', name: 'teacher')]
    public function index(): Response
    {
        $teachers =$this->getDoctrine()->getRepository(Teacher::class)->findAll();
        if (!$teachers) {
            $this->addFlash("Error", "No teachers found in the database.");
            return $this->redirectToRoute("home");
        }
        return $this->render('teacher/index.html.twig', [
            'Teachers' => $teachers,
        ]);
    }

    #[Route('/detail/{id}', name: 'teacher_detail')]
    public function show($id)
    {
        $teacher = $this->getDoctrine()->getRepository(Teacher::class)->find($id);
        if (!$teacher) {
            $this->addFlash("Error", "Undefined teacher!");
            return $this->redirectToRoute("teacher");
        }
        return $this->render('teacher/detail.html.twig', [
            'teacher' => $teacher,
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

    #[Route('/delete/{id}', name: 'delete_teacher')]
    public function teacherDelete($id, ManagerRegistry $managerRegistry)
    {
        $teacher = $this->getDoctrine()->getRepository(Teacher::class)->find($id);
        if (!$teacher) {
            $this->addFlash("Error", "Teacher not found !");
            return $this->redirectToRoute("teacher");
        }
        elseif (count($teacher->getCourses()) > 0) {
            $this->addFlash("Error", "Major cannot be deleted because it is used in courses !");
        }
        else {
        $manager = $managerRegistry->getManager();
        $manager->remove($teacher);
        $manager->flush();
        $this->addFlash("Success", "Teacher deleted successfully !");
        return $this->redirectToRoute("teacher");
        }
    }
    #[Route('/edit/{id}', name: 'edit_teacher')]
    public function teacherEdit($id, Request $request, ManagerRegistry $managerRegistry)
    {
        $teacher = $this->getDoctrine()->getRepository(Teacher::class)->find($id);
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($teacher);
            $manager->flush();
            $this->addFlash("Success", "Teacher edited successfully !");
            return $this->redirectToRoute("teacher");
        }
        return $this->renderForm(
            'teacher/edit.html.twig',
            [
                'teacherForm' => $form
            ]
        );
    }

    

}
