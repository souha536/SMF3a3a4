<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/first', name: 'app_first')]
    public function index(): Response
    {
        return $this->render('first/index.html.twig', [
            'controller_name' => 'Bonjour ESPRIT', 'temperature' =>'Trés Froid'
        ]);
    }
    
    #[Route('/second', name: 'app_second')]
    public function test(): Response
    {
        return $this->render('first/test.html.twig', [
            'controller_name' => 'FirstController',
        ]);
    }

    #[Route('/view/{name}', name: 'view')]
    public function view($name): Response
    {
        $age=15;

        return $this->render('first/index.html.twig', [
            'controller_name' => 'Bonjour ESPRIT',"age"=> $age, 'temperature' =>'Trés Froid','nom' => $name
        ]);
    }
}
