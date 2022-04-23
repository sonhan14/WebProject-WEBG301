<?php

namespace App\Controller;

use App\Entity\Student;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'student')]
    
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

}
