<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Entity\Lecturer;
use App\Form\LecturerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @IsGranted("ROLE_USER")
*/

class LecturerController extends AbstractController
{
    #[Route('/lecturer', name: 'lecturer_index')]
    public function lecturerIndex() {
        $lecturers = $this->getDoctrine()->getRepository(Lecturer::class)->findAll();
        return $this->render(
            'lecturer/index.html.twig',
            [
                'lecturers' => $lecturers
            ]
        );
    }
    
      
    #[Route('/lecturer/detail/{id}', name:'lecturer_detail')]
     
        public function lecturerDetail(Request $request, $id)
        {
             $lecturer = $this->getDoctrine()->getRepository(Lecturer::class)->find($id);
             $form = $this->createForm(LecturerType::class,$lecturer);
             $form->handleRequest($request);

             if ($lecturer == null) {
                 $this->addFlash('Error', 'Lecturer not found !');
                 return $this->redirectToRoute('lecturer_index');
             } else { //$lecturer != null
                 return $this->render(
                     'lecturer/detail.html.twig', 
                     [
                         'lecturer' => $lecturer
                     ]
                 );
             }
        }
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("lecturer/add", name="lecturer_add")
     */
    public function addLecturer(Request $request){
        $lecturer = new Lecturer();
        $form = $this->createForm(LecturerType::class, $lecturer);
        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()) {
             //code xử lý ảnh upload
            //B1: lấy ảnh từ file upload
            $image = $lecturer->getAvatar();
            //B2: tạo tên mới cho ảnh => tên file ảnh là duy nhất
            $imgName = uniqid(); //unique ID
            //B3: lấy ra phần đuôi (extension) của ảnh
            $imgExtension = $image -> guessExtension();
            //B4: gộp tên mới + đuôi tạo thành tên file ảnh hoàn thiện
            $imageName = $imgName . "." . $imgExtension;
            //B5: di chuyển file ảnh upload vào thư mục chỉ định
            try {
                $image->move(
                    $this->getParameter('lecturer_avatar'),
                    $imageName
                    //Lưu ý: cần khai báo tham số đường dẫn của thư mục
                    //cho "book_cover" ở file config/services.yaml
                );
            } catch (FileException $e) {
                throwException($e);
            }
            //B6: lưu tên vào database
            $lecturer->setAvatar($imageName);


            $manager = $this->getDoctrine()->getManager();

            $manager->persist($lecturer);

            $manager->flush();

            $this -> addFlash('Success', "Lecturer Added Success!");

            return $this -> redirectToRoute('lecturer_index');
        }

        return $this -> render('lecturer/add.html.twig',
        [
            'form' => $form->createView(),
        ]);

    }
    /**
     * @IsGranted("ROLE_STAFF")
     * @Route("lecturer/edit/{id}", name="lecturer_edit")
     */
    public function editLecturer($id, Request $request){
        $lecturer = $this-> getDoctrine() -> getRepository(Lecturer::class)-> find($id);

        if($lecturer == null){
            $this -> addFlash('Error', 'Lecturer Not Found !');
            return $this -> redirectToRoute('lecturer_index');
        }

        else{
            $form = $this -> createForm(LecturerType::class, $lecturer);
            $form -> handleRequest($request);

            if ($form -> isSubmitted() && $form -> isValid()) 
            {
                // lấy dữ liệu ảnh từ form 
                $file = $form['avatar'] -> getData();

                if($file != null) {
                    $image = $lecturer -> getAvatar();

                    //  tạo tên mới cho ảnh => tên file ảnh là duy nhất
                    $imgName = uniqid();

                    // lấy ra phần đuôi (extension) của ảnh
                    $imgExtension = $image->guessExtension();

                    $imageName = $imgName . "." . $imgExtension;

                    try {
                        $image->move(
                            $this->getParameter('lecturer_avatar'),
                            $imageName
                            //Lưu ý: cần khai báo tham số đường dẫn của thư mục
                            //cho "book_cover" ở file config/services.yaml
                        );
                    } catch (FileException $e) {
                        throwException($e);
                    }
                    // lưu tên vào database
                    $lecturer->setAvatar($imageName);
                }

                $manager = $this -> getDoctrine()->getManager();
                $manager->persist($lecturer);
                $manager->flush();

                $this->addFlash('Success', "Edit Lecturer successfully !");
                return $this->redirectToRoute("lecturer_index");
            }

            return $this -> render('lecturer/edit.html.twig',
            [
                'form' => $form->createView()
            ]);
        }
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("lecturer/delete/{id}", name="lecturer_delete")
     */
    public function deleteLecturer( $id) 
    {
        $lecturer = $this->getDoctrine()->getRepository(Lecturer::class)->find($id);
        if($lecturer == null){
            $this->addFlash('Error', 'Not found lecturer');
        } else{
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($lecturer);
            $manager->flush();
            $this->addFlash('Success', 'Lecturer was deleted');
        }
        return $this->redirectToRoute('lecturer_index');
    }
}
