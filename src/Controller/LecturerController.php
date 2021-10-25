<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Lecturer;

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
     
        public function lecturerDetail($id)
        {
             $lecturer = $this->getDoctrine()->getRepository(Lecturer::class)->find($id);
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
        
    }
    /**
     * @Route("lecturer/edit/{id}", name="lecturer_edit")
     */
    public function editLecturer($id) 
    {
        $lecturer = $this->getDoctrine()->getRepository(Lecturer::class)->find($id);
        $form = $this->createForm(LecturerType::class,$lecturer);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $manager-> persit($lecturer);
            $manager->flush();

            $this->addFlash('Update lecturer successfully');
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
