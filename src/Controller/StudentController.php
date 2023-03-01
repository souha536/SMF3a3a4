<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }
    #[Route('/student/add', name: 'addStudent')]
    public function addStudent(ManagerRegistry $doctrine, Request $request): Response
    {
        $student= new Student;
        $form=$this->createForm(StudentType::class, $student);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
 
        if ($form->isSubmitted()) {
            $em= $doctrine->getManager();
            $em->persist($student);
            $em->flush();
        return $this->redirectToRoute('listStudent');
        }
        return $this->render('student/addStudent.html.twig', [
            'form'=> $form->createView(),
        ]);
    }
        #[Route('/listStudent', name: 'listStudent')]
        public function Student(ManagerRegistry $doctrine): Response
        {
            $repo=$doctrine->getRepository(Student::class);
            $students=$repo->findAll();
            return $this->render('student/list.html.twig', [
                'students' => $students,
            ]);
    }
}
