<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[Route('/student')]
class StudentController extends AbstractController
{
    #[Route('/', name: 'student')]
    
    public function index(): Response
    {
        $students = $this->getDoctrine()->getRepository(Student::class)->findAll();
        if (!$students) {
            throw $this->createNotFoundException(
                'No students found in the database.'
            );
        }
        return $this->render('student/index.html.twig', [
            'students' => $students,
        ]);
    }

    #[Route('/detail/{id}', name: 'student_detail')]
    public function show($id)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        if (!$student) {
            $this->addFlash("Error", "Student not found !");
            return $this->redirectToRoute("student");
        }
        return $this->render('student/detail.html.twig', [
            'student' => $student,
        ]);
    }

    #[Route('/add', name: 'add_student')]
    public function studentAdd(Request $request, ManagerRegistry $managerRegistry)
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($student);
            $manager->flush();
            $this->addFlash("Success", "Student added successfully !");
            return $this->redirectToRoute("student");

        }
        return $this->renderForm(
            'student/add.html.twig',
                   [
                'studentForm' => $form
            ]
            
        );
    }

    #[Route('/delete/{id}', name: 'delete_student')]
    public function studentDelete($id, ManagerRegistry $managerRegistry)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        if (!$student){
            $this->addFlash("Error", "Student not found !");
            return $this->redirectToRoute("student");
        }
        $manager = $managerRegistry->getManager();
        $manager->remove($student);
        $manager->flush();
        $this->addFlash("Success", "Student deleted successfully !");
        return $this->redirectToRoute("student");
        
}

    #[Route('/edit/{id}', name: 'edit_student')]
    public function studentEdit($id, Request $request, ManagerRegistry $managerRegistry)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        if (!$student){
            $this->addFlash("Error", "Student not found !");
            return $this->redirectToRoute("student");
        }
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($student);
            $manager->flush();
            $this->addFlash("Success", "Student edited successfully !");
            return $this->redirectToRoute("student");
        }
        return $this->renderForm(
            'student/edit.html.twig',
            [
                'studentForm' => $form
            ]
        );
    }
}
