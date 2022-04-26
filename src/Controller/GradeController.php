<?php

namespace App\Controller;

use App\Entity\Grade;
use App\Form\GradeType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 #[Route('/grade')]
class GradeController extends AbstractController
{
    #[Route('/', name: 'app_grade')]
    public function index(): Response
    {
        $grades = $this->getDoctrine()->getRepository(Grade::class)->findAll();
        if (!$grades) {
            throw $this->createNotFoundException(
                'No grades found in the database.'
            );
        }
        return $this->render('grade/index.html.twig', [
            'grades' => $grades,
        ]);

    }
    #[Route('/detail/{id}', name: 'grade_detail')]
    public function gradeDetail($id)
    {
        $grade = $this->getDoctrine()->getRepository(Grade::class)->find($id);
        if (!$grade) {
            $this->addFlash("Error", "Grade not found !");
            return $this->redirectToRoute("app_grade");
        }
        return $this->render('grade/detail.html.twig', [
            'grade' => $grade,
        ]);

    }

    #[Route('/add', name: 'add_grade')]
    public function addGrade(Request $request, ManagerRegistry $managerRegistry)
    {
        $grade = new Grade();
        $form = $this->createForm(GradeType::class, $grade);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($grade);
            $manager->flush();
            $this->addFlash("Success", "Grade added successfully !");
            return $this->redirectToRoute("app_grade"); 
        }

        return $this->renderForm(
            'grade/add.html.twig',
            [
                'gradeForm' => $form
            ]
        );
    }

    #[Route('/delete/{id}', name: 'delete_grade')]
    public function deleteGrade($id, ManagerRegistry $managerRegistry)
    {
        $grade = $this->getDoctrine()->getRepository(Grade::class)->find($id);
        if (!$grade) {
            $this->addFlash("Error", "Grade not found !");
            return $this->redirectToRoute("app_grade");
        }
        $manager = $managerRegistry->getManager();
        $manager->remove($grade);
        $manager->flush();
        $this->addFlash("Success", "Grade deleted successfully !");
        return $this->redirectToRoute("app_grade");
    }
    
    #[Route('/edit/{id}', name: 'edit_grade')]
    public function editGrade($id, Request $request, ManagerRegistry $managerRegistry)
    {
        $grade = $this->getDoctrine()->getRepository(Grade::class)->find($id);
        if (!$grade) {
            $this->addFlash("Error", "Grade not found !");
            return $this->redirectToRoute("app_grade");
        }
        $form = $this->createForm(GradeType::class, $grade);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($grade);
            $manager->flush();
            $this->addFlash("Success", "Grade updated successfully !");
            return $this->redirectToRoute("app_grade");
        }

        return $this->renderForm(
            'grade/edit.html.twig',
            [
                'gradeForm' => $form
            ]
        );
    }
}
