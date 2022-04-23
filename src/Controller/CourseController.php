<?php

namespace App\Controller;

use App\Entity\Course;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CourseController extends AbstractController
{
    #[Route('/course', name: 'course')]
    public function index(): Response
    {
        $courses = $this->getDoctrine()->getRepository(Course::class)->findAll();
        if (!$courses) {
            throw $this->createNotFoundException(
                'No courses found in the database.'
            );
        }
        return $this->render('course/index.html.twig', [
            'courses' => $courses,
        ]);
    }
}
