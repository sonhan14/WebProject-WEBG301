<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/course')]

class CourseController extends AbstractController
{
    #[Route('/', name: 'course')]
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

    #[Route('/detail/{id}', name: 'course_detail')]
    public function courseDetail($id)
    {
        $course = $this->getDoctrine()->getRepository(Course::class)->find($id);
        if (!$course) {
            $this->addFlash("Error", "Course not found !");
            return $this->redirectToRoute("course");
        }
        return $this->render('course/detail.html.twig', [
            'course' => $course,
        ]);
    }

    #[Route('/add', name: 'add_course')]
    public function addCourse(Request $request, ManagerRegistry $managerRegistry)
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($course);
            $manager->flush();
            $this->addFlash("Success", "Course added successfully !");
            return $this->redirectToRoute("course");
        }
        return $this->renderForm(
            'course/add.html.twig',
            [
                'courseForm' => $form
            ]
        );
    }

    #[Route('/delete/{id}', name: 'delete_course')]
    public function deleteCourse($id, ManagerRegistry $managerRegistry)
    {
        $course = $this->getDoctrine()->getRepository(Course::class)->find($id);
        if (!$course){
            $this->addFlash("Error", "Course not found !");
            return $this->redirectToRoute("course");
        }
        elseif ($course->getStudents()->count() > 0) {
            $this->addFlash("Error", "Course cannot be deleted because it has students enrolled !");
        }
        else {
            $manager = $managerRegistry->getManager();
            $manager->remove($course);
            $manager->flush();
            $this->addFlash("Success", "Course deleted successfully !");
        }
        return $this->redirectToRoute("course");
    }

    #[Route('/edit/{id}', name: 'edit_course')]
    public function editCourse($id, Request $request, ManagerRegistry $managerRegistry)
    {
        $course = $this->getDoctrine()->getRepository(Course::class)->find($id);
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($course);
            $manager->flush();
            $this->addFlash("Success", "Course edited successfully !");
            return $this->redirectToRoute("course");
        }
        return $this->renderForm(
            'course/edit.html.twig',
            [
                'courseForm' => $form
            ]
        );
    }

    #[Route('/search', name: 'search_course')]
    public function searchCourse(Request $request, CourseRepository $courseRepository)
    {
        $keyword = $request->get('keyword');
        $courses = $courseRepository->search($keyword);
        return $this->render('course/index.html.twig', [
            'courses' => $courses,
        ]);
    }
}
