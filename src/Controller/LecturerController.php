<?php

namespace App\Controller;

use App\Entity\Lecturer;
use App\Entity\Subject;
use App\Form\LecturerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;

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
     * @Route("lecturer/add", name="lecturer_add")
     */
    public function addLecturer(Request $request) 
    {
            $lecturer = new Lecturer();
            $form = $this->createForm(LecturerType::class,$lecturer);
            $form->handleRequest($request);
    
            if($form->isSubmitted() && $form->isValid()){
                //code xử lý ảnh upload
                //1. Lấy ảnh từ file upload
                $image = $book->getAvatar();
                //2. tạo tên mới cho ảnh => tên file ảnh là duy nhất
                $imgName = uniqid(); //unique ID
                //3. lấy phần đuôi (extension) của ảnh
                $imgExtension = $imgName->guessExtension();
                //4. gộp tên mới + đuôi tạo thành file ảnh hoàn thiện 
                $imageName = $imgName . "." . $imgExtension;
                //5. di chuyển file ảnh upload vào thư mục chỉ định
                try{
                    $image->move(
                        $this->getParameter('lecturer_avatar'), $imageName
                        //Lưu ý: cần khai báo tham số đường dẫn của thư mục cho lecturer_avatar ở file 
                        // config/services.yaml
                    );
                } catch(FileException $e){
                    throwException($e);
                }
                //6. lưu tên ảnh vào database
                $lecturer->setAvatar($imageName);

                $manager = $this->getDoctrine()->getManager();
                $manager-> persist($lecturer);
                $manager->flush();
    
                $this->addFlash('Success','Add lecturer successfully');
                return $this->redirectToRoute("lecturer_index");
            }
    
            return $this->render(
                "lecturer/add.html.twig",
                [
                    'form' => $form->createView()
                ]
                );
        
    }
    /**
     * @Route("lecturer/edit/{id}", name="lecturer_edit")
     */
    public function editLecturer(Request $request, $id) 
    {
        $lecturer = $this->getDoctrine()->getRepository(Lecturer::class)->find($id);
        $form = $this->createForm(LecturerType::class,$lecturer);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
              //code xử lý ảnh upload
                $file = $form['avatar']->getData();
                if($file != null){
                    $image = $book->getAvatar();             
                $imgName = uniqid(); //unique ID
                
                $imgExtension = $imgName->guessExtension();
                
                $imageName = $imgName . "." . $imgExtension;
                
                try{
                    $image->move(
                        $this->getParameter('lecturer_avatar'), $imageName
                       
                    );
                } catch(FileException $e){
                    throwException($e);
                }
                //6. lưu tên ảnh vào database
                $lecturer->setAvatar($imageName);
                }
                

            $manager = $this->getDoctrine()->getManager();
            $manager-> persist($lecturer);
            $manager->flush();

            $this->addFlash('Success','Update lecturer successfully');
            return $this->redirectToRoute("lecturer_index");
        }

        return $this->render(
            "lecturer/edit.html.twig",
            [
                'form' => $form->createView()
            ]
            );
    }

    /**
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
