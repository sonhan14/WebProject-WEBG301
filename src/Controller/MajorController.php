<?php

namespace App\Controller;

use App\Entity\Major;
use App\Form\MajorType;
use App\Repository\MajorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/major')]

class MajorController extends AbstractController
{
    #[Route('/', name: 'major')]
    public function index(): Response
    {
        $majors = $this->getDoctrine()->getRepository(Major::class)->findAll();
        if (!$majors) {
            $this->addFlash("Error", "No majors found in the database.");
            return $this->redirectToRoute("home");
        }
        return $this->render('major/index.html.twig', [
            'majors' => $majors,
        ]);
    }

    #[Route('/detail/{id}', name: 'major_detail')]
    public function show($id)
    {
        $major = $this->getDoctrine()->getRepository(Major::class)->find($id);
        if (!$major) {
            $this->addFlash("Error", "Major not found !");
            return $this->redirectToRoute("major");
        }
        return $this->render('major/detail.html.twig', [
            'major' => $major,
        ]);
    }

    #[Route('/add', name: 'add_major')]
    public function majorAdd(Request $request, ManagerRegistry $managerRegistry)
    {
        $major = new Major();
        $form = $this->createForm(MajorType::class, $major);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($major);
            $manager->flush();
            $this->addFlash("Success", "Major added successfully !");
            return $this->redirectToRoute("major");
        }
        return $this->renderForm(
            'major/add.html.twig',
            [
                'majorForm' => $form
            ]
        );
    }

    #[Route('/delete/{id}', name: 'delete_major')]
    public function majorDelete($id, ManagerRegistry $managerRegistry)
    {
        $major = $this->getDoctrine()->getRepository(Major::class)->find($id);
        if (!$major){
            $this->addFlash("Error", "Major not found !");
            return $this->redirectToRoute("major");
        }
        elseif (count($major->getCourses()) > 0) {
            $this->addFlash("Error", "Major cannot be deleted because it is used in courses !");
        }
        else {
            $manager = $managerRegistry->getManager();
            $manager->remove($major);
            $manager->flush();
            $this->addFlash("Success", "Major deleted successfully !");
        }
        return $this->redirectToRoute("major");
    }

    #[Route('/edit/{id}', name: 'edit_major')]
    public function majorEdit($id, Request $request, ManagerRegistry $managerRegistry)
    {
        $major = $managerRegistry->getRepository(Major::class)->find($id);
        $form = $this->createForm(MajorType::class, $major);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($major);
            $manager->flush();
            $this->addFlash("Success", "Major edited successfully !");
            return $this->redirectToRoute("major");
        }
        return $this->renderForm(
            'major/edit.html.twig',
            [
                'majorForm' => $form
            ]
        );
    }

    #[Route('/search', name: 'search_major')]
    public function majorSearch(Request $request, MajorRepository $majorRepository)
    {
        $keyword = $request->get('keyword');
        $majors = $majorRepository->search($keyword);
        return $this->render('major/index.html.twig', [
            'majors' => $majors,
        ]);

    }

    #[Route('/viewCourse/{id}', name: 'view_course_major')]
    public function viewCourse($id, ManagerRegistry $managerRegistry)
    {
        $major = $managerRegistry->getRepository(Major::class)->find($id);
        $courses = $major->getCourses();
        return $this->render('course/index.html.twig', [
            'courses' => $courses,
        ]);
    }

    
}