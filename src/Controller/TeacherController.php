<?php

namespace App\Controller;

use App\Entity\FeedBack;
use App\Entity\Teacher;
use App\Form\TeacherType;
use App\Repository\TeacherRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use function PHPUnit\Framework\throwException;


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
        //     // B1: tạo biến $image để lấy ra tên image khi upload từ form
        //     $image = $teacher->getAvatar();
        //     // B2: tao ten moi cho anh => ten file anh la duy nhat
        //     $imageName = uniqid(); // unique ID
        //     // B3: lay ra duoi (extensions) cua ảnh
        //     $imageExtension = $image->guessExtension();
        //     //Note: cần bỏ data type "string" trong hàm getAvata() + setAvata()
        //    //để biển $image thành object thay vì string
        //    //B4: ghép thành tên file ảnh hoàn thiện
        //     $imageName = $imageName . '.' . $imageExtension;
        //     // B5: di chuyen file anh upload vao thu muc chi dinh
        //     try {
        //         $image->move(
        //             $this->getParameter('teacher_avatar'),
        //             $imageName
        //             // can khai bao tham so duong dan cua thu muc
        //             // cho teacher_AgetAvatar o file config/services.yaml 
        //         );
        //     } catch (FileException $e) {
        //         throwException($e);
        //     }
        //     // B6: Luu ten anh vao database
        //     $teacher->setAvatar($imageName);
            //đẩy dữ liệu vào db
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
            $this->addFlash("Error", "Undefined teacher!");
           
        }
        else if(count($teacher->getFeedBacks())!=0){
            $this->addFlash("Error", "Khong the xoa giao vien");
        }
        else {
        $manager = $managerRegistry->getManager();
        $manager->remove($teacher);
        $manager->flush();
        $this->addFlash("Success", "Teacher has been deleted!");
        
        }
        return $this->redirectToRoute("teacher");
    }
    #[Route('/edit/{id}', name: 'edit_teacher')]
    public function teacherEdit($id, Request $request, ManagerRegistry $managerRegistry)
    {
        $teacher = $this->getDoctrine()->getRepository(Teacher::class)->find($id);
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // // B1: Lay du lieu anh tu form
            // $file = $form['avatar']->getData();
            // // kiem tra nguoi dung co chon anh hay khong
            // if ($file != null) {
            //     // B1: Lay anh tu file upload
            //     $image = $teacher->getAvatar();
            //     // B2: tao ten moi cho anh => ten file anh la duy nhat
            //     $imageName = uniqid(); // unique ID
            //     // B3: lay ra duoi cua anh
            //     $imageExtension = $image->guessExtension();
            //     // B4: Merge ten moi + duoi cua anh
            //     $imageName = $imageName . '.' . $imageExtension;
            //     // B5: di chuyen file anh upload vao thu muc chi dinh
            //     try {
            //         $image->move(
            //             $this->getParameter('teacher_avatar'),
            //             $imageName
            //             // can khai bao tham so duong dan cua thu muc
            //             // cho teacher_AgetAvatar o file config/services.yaml 
            //         );
            //     } catch (FileException $e) {
            //         throwException($e);
            //     }
            //     // B6: Luu ten anh vao database
            //     $teacher->setAvatar($imageName);
            // }

            $manager = $this->getDoctrine()->getManager();
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

    #[Route('/viewFeedback/{id}', name: 'viewfeedback')]
    public function viewFeedback($id, ManagerRegistry $managerRegistry)
    {
        $teacher = $managerRegistry->getRepository(FeedBack::class)->find($id);
        $feedBack = $teacher->getFeedback();
        return $this->render('feed_back/index.html.twig', [
            'feedback' => $feedBack,
        ]);
    }

    

}
