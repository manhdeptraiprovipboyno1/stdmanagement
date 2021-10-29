<?php

namespace App\Controller;
use App\Entity\ClassM;
use App\Entity\Lecturer;
use App\Form\ClassMType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @IsGranted("ROLE_USER")
*/

class ClassMController extends AbstractController
{
    #[Route('/class_m', name: 'classM_index')]
    public function classMIndex(){
        $classes = $this->getDoctrine()->getRepository(classM::class)->findAll();
        return $this->render(
            'class_m/index.html.twig',
            [
                'classes' => $classes
            ]
        );
    }

    
    #[Route('/class_m/detail/{id}', name: 'classM_detail')]
    public function classMDetail($id)
    {
        $classes = $this->getDoctrine()->getRepository(classM::class)->find($id);
        if ($classes == null) {
            $this->addFlash('Error', 'Class not found !');
            return $this->redirectToRoute('classM_index');
        } else { //$class != null
            return $this->render(
                'class_m/detail.html.twig',
                [
                    'class' => $classes
                ]
            );
        }
    }


    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("class_m/delete/{id}", name="classM_delete")
     */
    public function deleteClassM($id)
    {
        $classes = $this->getDoctrine()->getRepository(classM::class)->find($id);
        if ($classes == null) {
            $this->addFlash('Error', 'Class not found !');
        } else { //$classes != null
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($classes);
            $manager->flush();
            $this->addFlash('Success', 'Class has been deleted !');
        }
        return $this->redirectToRoute('classM_index');
    }


    /**
    * @IsGranted("ROLE_ADMIN")
    */
    #[Route('/class_m/add', name : "classM_add")]
    public function addClassAction(Request $request)
    {
        $classes = new classM();
        $form = $this->createForm(classMType::class, $classes);
        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()) {

            $manager = $this-> getDoctrine() -> getManager();
            $manager->persist($classes);
            $manager->flush();

            $this -> addFlash('Success', "Class Added Success!");

            return $this -> redirectToRoute('classM_index');
        }
        return $this -> render('class_m/add.html.twig', [
            'form' => $form->createView()
        ]);

    }


    /**
    * @IsGranted("ROLE_STAFF")
    */
    #[Route('/class_m/update/{id}', name : "classM_edit")]
    public function editClassAction($id, Request $request)
    {
        $classes = $this -> getDoctrine() -> getRepository(classM::class)
            -> find($id);

        $form = $this -> createForm(classMType::class, $classes);
        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()){
            $manager = $this-> getDoctrine() -> getManager();

            $manager->persist($classes);

            $manager->flush();

            $this -> addFlash('Success', "Class Updated Successfully !");

            return $this -> redirectToRoute('classM_index');
        }

        return $this -> render('class_m/edit.html.twig', [
            'form' => $form -> createView()
        ]);
    }
}