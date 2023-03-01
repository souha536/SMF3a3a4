<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }
    #[Route('/listClassroom', name: 'listClassroom')]
    public function list(ManagerRegistry $doctrine): Response
    {
        $repositoryClassroom=$doctrine->getRepository(Classroom::class);
        $classrooms=$repositoryClassroom->findAll();
        return $this->render('classroom/list.html.twig', [
            'classrooms' => $classrooms,
        ]);
    }
    #[Route('/deleteClassroom/{id}', name: 'DeleteClassroom')]
    public function deleteClassroom($id, ManagerRegistry $doctrine): Response
    {
        //Trouver le bon Classroom
        $repoC = $doctrine->getRepository(Classroom::class);
        $classroom= $repoC->find($id);
        //Utiliser Manager pour supprimer le classroom trouvé
        $em= $doctrine->getManager();
        $em->remove($classroom);
        $em->flush();

        return $this->redirectToRoute('listClassroom');
    }
    #[Route('/showClassroom/{id}', name: 'showClassroom')]
    public function showClassroom($id, ManagerRegistry $doctrine): Response
    {
        //Trouver le bon Classroom
        $repoC = $doctrine->getRepository(Classroom::class);
        $classroom= $repoC->find($id);
     

        return $this->render('classroom/showC.html.twig', [
            'classroom' => $classroom,
        ]);
    }
    #[Route('/classroom/add', name: 'addClassroom')]
    public function addClassroom(ManagerRegistry $doctrine, Request $request): Response
    {
        $classroom= new Classroom;
        $form=$this->createForm(ClassroomType::class, $classroom);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
 
        if ($form->isSubmitted()) {
            $em= $doctrine->getManager();
            $em->persist($classroom);
            $em->flush();
        return $this->redirectToRoute('listClassroom');
        }
        return $this->render('classroom/addClassroom.html.twig', [
            'formClassroom'=> $form->createView(),
        ]);
    }
    #[Route('/updateClassroom/{id}', name: 'updateClassroom')]

    public function updateClassroom(Request $request,ManagerRegistry $doctrine ,Classroom $classroom)
    {
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->add('Update',SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('showClassroom', ['id' => $classroom->getId()]);
        }
                return $this->render('classroom/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
