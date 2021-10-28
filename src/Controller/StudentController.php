<?php

namespace App\Controller;
use App\Entity\Student;
use App\Entity\ClassM;
use App\Form\StudentType;

use App\Entity\Subject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'student_index')]
    public function studentIndex()
    {
        $students = $this->getDoctrine()->getRepository(Student::class)->findAll();
        return $this->render('student/index.html.twig', [
            'students' => $students
        ]);
    }

    #[Route('/student/detail/{id}', name: 'student_detail')]
    public function studentDetail($id)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        if ($student == null) {
            $this->addFlash('Error', 'student not found !');
            return $this->redirectToRoute('student_index');
        } else { //$student != null
            return $this->render(
                'student/detail.html.twig',
                [
                    'student' => $student
                ]
            );
        }
    }

    /**
     * @Route("student/delete/{id}", name="student_delete")
     */
    public function deleteStudent($id)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        if ($student == null) {
            $this->addFlash('Error', 'Student not found !');
        } else { //$student != null
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($student);
            $manager->flush();
            $this->addFlash('Success', 'Student has been deleted !');
        }
        return $this->redirectToRoute('student_index');
    }

    /**
     * @Route("student/add", name="student_add")
     */
    public function addStudent(Request $request) 
    {
            $student = new Student();
            $form = $this->createForm(StudentType::class,$student);
            $form->handleRequest($request);
    
            if($form->isSubmitted() && $form->isValid()){
                //code xử lý ảnh upload
                //1. Lấy ảnh từ file upload
                $image = $student->getAvatar();
                //2. tạo tên mới cho ảnh => tên file ảnh là duy nhất
                $imgName = uniqid(); //unique ID
                //3. lấy phần đuôi (extension) của ảnh
                $imgExtension = $imgName->guessExtension();
                //4. gộp tên mới + đuôi tạo thành file ảnh hoàn thiện 
                $imageName = $imgName . "." . $imgExtension;
                //5. di chuyển file ảnh upload vào thư mục chỉ định
                try{
                    $image->move(
                        $this->getParameter('student_avatar'), $imageName
                        //Lưu ý: cần khai báo tham số đường dẫn của thư mục cho student_avatar ở file 
                        // config/services.yaml
                    );
                } catch(FileException $e){
                    throwException($e);
                }
                //6. lưu tên ảnh vào database
                $student->setAvatar($imageName);

                $manager = $this->getDoctrine()->getManager();
                $manager-> persist($student);
                $manager->flush();
    
                $this->addFlash('Success','Add student successfully');
                return $this->redirectToRoute("student_index");
            }
    
            return $this->render(
                "student/add.html.twig",
                [
                    'form' => $form->createView()
                ]
                );
        
    }

    /**
     * @Route("student/edit/{id}", name="student_edit")
     */
    public function editStudent(Request $request, $id) 
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        $form = $this->createForm(StudentType::class,$student);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
              //code xử lý ảnh upload
                //$file = $form['avatar']->getData();
                
                 $image = $student->getAvatar();             
                $imgName = uniqid(); //unique ID
                
                $imgExtension = $imgName->guessExtension();
                
                $imageName = $imgName . "." . $imgExtension;
                
                try{
                    $image->move(
                        $this->getParameter('student_avatar'), $imageName
                       
                    );
                } catch(FileException $e){
                    throwException($e);
                }
                //6. lưu tên ảnh vào database
                $student->setAvatar($imageName);
                
            $manager = $this->getDoctrine()->getManager();
            $manager-> persist($student);
            $manager->flush();

            $this->addFlash('Success','Update student successfully');
            return $this->redirectToRoute("student_index");
        }

        return $this->render(
            "student/edit.html.twig",
            [
                'form' => $form->createView()
            ]
            );
    }
}
