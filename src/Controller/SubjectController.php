<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Form\SubjectType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @IsGranted("ROLE_USER")
 */


class SubjectController extends AbstractController
{
    #[Route('/subject', name: 'subject_index')]
    public function subjectIndex() {
        $subjects = $this->getDoctrine()->getRepository(Subject::class)->findAll();
        return $this->render(
            'subject/index.html.twig',
            [
                'subjects' => $subjects
            ]
        );
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("subject/add", name="subject_add")
     */
    public function addSubject(Request $request) 
    {
        $subject = new Subject();
        $form = $this->createForm(SubjectType::class,$subject);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $manager-> persist($subject);
            $manager->flush();

            $this->addFlash('Success','Add subject successfully');
            return $this->redirectToRoute("subject_index");
        }

        return $this->render(
            "subject/add.html.twig",
            [
                'form' => $form->createView()
            ]
            );
    }

    /**
     * @IsGranted("ROLE_STAFF")
     * @Route("subject/edit/{id}", name="subject_edit")
     */
    public function editSubject(Request $request, $id) 
    {
        $subject = $this->getDoctrine()->getRepository(Subject::class)->find($id);
        $form = $this->createForm(SubjectType::class,$subject);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $manager-> persist($subject);
            $manager->flush();

            $this->addFlash('Update Success','Update subject successfully');
            return $this->redirectToRoute("subject_index");
        }

        return $this->render(
            "subject/edit.html.twig",
            [
                'form' => $form->createView()
            ]
            );
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("subject/delete/{id}", name="subject_delete")
     */
    public function deleteLecturer( $id) 
    {
        $subject = $this->getDoctrine()->getRepository(Subject::class)->find($id);
        if($subject == null){
            $this->addFlash('Error', 'Not found subject');
        } else{
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($subject);
            $manager->flush();
            $this->addFlash('Success', 'Subject was deleted');
        }
        return $this->redirectToRoute('subject_index');
    }
}
