<?php


namespace App\Controller;

use App\Entity\FeedBack;
use App\Form\FeedbackType;
use App\Repository\FeedBackRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use function PHPUnit\Framework\throwException;

#[Route('/feedback')]

class FeedBackController extends AbstractController
{
    #[Route('/', name: 'app_feed_back')]
    public function index(): Response
    {
        $feedback =$this->getDoctrine()->getRepository(FeedBack::class)->findAll();
        if (!$feedback) {
            throw $this->createNotFoundException(
                'No feedback found in the database.'
            );
        }
        return $this->render('feed_back/index.html.twig', [
            'feedback' => $feedback,
        ]);
    }

    #[Route('/detail/{id}', name: 'feedback_detail')]
    public function show($id)
    {
        $feedback = $this->getDoctrine()->getRepository(feedback::class)->find($id);
        if (!$feedback) {
            $this->addFlash("Error", "Undefined feedback!");
            return $this->redirectToRoute("feedback");
        }
        return $this->render('feed_back/detail.html.twig', [
            'feedback' => $feedback,
        ]);
    }

    #[Route('/add', name: 'add_feedback')]
    public function add(Request $request, ManagerRegistry $managerRegistry)
    {
        $feedback = new Feedback();
        $form = $this->createForm(FeedbackType::class, $feedback);
        //yêu cầu xử lý form 
        $form -> handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($feedback);
            $manager->flush();
            $this->addFlash("Success", "feedback added successfully !");
            return $this->redirectToRoute("app_feed_back");
        }
        return $this->renderForm(
            'feed_back/add.html.twig',
            [
                'feedbackForm' => $form
            ]
        );
    }

    #[Route('/delete/{id}', name: 'delete_feedback')]
    public function deleteFeedback($id, ManagerRegistry $managerRegistry)
    {
        $feedback = $this->getDoctrine()->getRepository(FeedBack::class)->find($id);
        if (!$feedback){
            $this->addFlash("Error", "Feedback not found !");
            return $this->redirectToRoute("app_feed_back");
        }
        else {
            $manager = $managerRegistry->getManager();
            $manager->remove($feedback);
            $manager->flush();
            $this->addFlash("Success", "Feedback deleted successfully !");
        }
        return $this->redirectToRoute("app_feed_back");
    }

    #[Route('/edit/{id}', name: 'edit_feedback')]
    public function editfeedback($id, Request $request, ManagerRegistry $managerRegistry)
    {
        $feedback = $this->getDoctrine()->getRepository(FeedBack::class)->find($id);
        $form = $this->createForm(FeedbackType::class, $feedback);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($feedback);
            $manager->flush();
            $this->addFlash("Success", "Feedback edited successfully !");
            return $this->redirectToRoute("app_feed_back");
        }
        return $this->renderForm(
            'feed_back/edit.html.twig',
            [
                'feedbackForm' => $form
            ]
        );
    }
    
}
