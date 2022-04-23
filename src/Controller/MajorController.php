<?php

namespace App\Controller;

use App\Entity\Major;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MajorController extends AbstractController
{
    #[Route('/major', name: 'major')]
    public function index(): Response
    {
        $majors = $this->getDoctrine()->getRepository(Major::class)->findAll();
        if (!$majors) {
            throw $this->createNotFoundException(
                'No majors found in the database.'
            );
        }
        return $this->render('major/index.html.twig', [
            'majors' => $majors,
        ]);
    }

    #[Route('/major/{id}', name: 'major_detail')]
    public function show($id)
    {
        $major = $this->getDoctrine()->getRepository(Major::class)->find($id);
        if (!$major) {
            throw $this->createNotFoundException(
                'No major found in the database.'
            );
        }
        return $this->render('major/detail.html.twig', [
            'major' => $major,
        ]);
    }
}
