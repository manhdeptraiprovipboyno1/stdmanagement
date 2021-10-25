<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassMController extends AbstractController
{
    #[Route('/classm', name: 'class_m')]
    public function index(): Response
    {
        return $this->render('class_m/index.html.twig', [
            'controller_name' => 'ClassMController',
        ]);
    }
}
