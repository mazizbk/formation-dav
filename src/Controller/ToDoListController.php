<?php

namespace App\Controller;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ToDoListController extends AbstractController
{
    #[Route('/to/do/list', name: 'app_to_do_list')]
    public function index(): Response
    {


        return $this->render('to_do_list/index.html.twig', [
            'controller_name' => 'ToDoListController',
        ]);
    }


    #[Route('/to/do/list/create', name: 'create_task',methods: 'POST')]
    public function create(Request $request,EntityManagerInterface $entityManager,ValidatorInterface $validator) :Response
    {
        $taskDescription = $request->request->get('task_description');
        $task = new Task();

        $errors = $validator->validate($task);

        if(!count($errors)) {

            $task->setTaskDescription($taskDescription);
            $entityManager->persist($task);
            $entityManager->flush();
        }else{
            $messages = [];
            foreach ($errors as $violation) {
                $messages[] = $violation->getMessage();
            }
            $this->addFlash(
                'error', $messages
            );
        }

        return $this->redirectToRoute('app_to_do_list');

    }

    #[Route('/to/do/list/switch/{id}', name: 'switch_task',methods: 'GET')]
    public function switch($id) {

    }


    #[Route('/to/do/list/remove/{id}', name: 'remove_task',methods: 'GET')]
    public function remove($id) {

    }

}

