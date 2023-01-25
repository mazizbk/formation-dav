<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ToDoListController extends AbstractController
{
    #[Route('/to/do/list', name: 'app_to_do_list')]
    public function index(TaskRepository  $taskRepository): Response
    {
        $tasks = $taskRepository->findAll();

        return $this->render('to_do_list/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }


    #[Route('/to/do/list/create', name: 'create_task', methods: 'POST')]
    public function create(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $taskDescription = $request->request->get('task_description');
        $task = new Task();
        $constraints = [
            new NotBlank(), // Allow relative protocol
        ];
        $errors = $validator->validate($taskDescription, $constraints);

        if (count($errors) === 0) {

            $task->setTaskDescription($taskDescription);
            $entityManager->persist($task);
            $entityManager->flush();
        } else {
            $messages = [];
            foreach ($errors as $violation) {
                $messages[] = $violation->getMessage();
            }
            $this->addFlash(
                'error',
                $messages
            );
        }

        return $this->redirectToRoute('app_to_do_list');
    }

    #[Route('/to/do/list/switch/{id}', name: 'switch_task', methods: 'GET')]
    public function switch(Task $task, EntityManagerInterface $entityManager)
    {
        $task->setStatusTask(!$task->isStatusTask());
        $entityManager->flush();
        return $this->redirectToRoute('app_to_do_list');
    }



    #[Route('/to/do/list/remove/{id}', name: 'remove_task', methods: 'GET')]
    public function remove(Task $id, EntityManagerInterface $entityManager)
    {

        $entityManager->remove($id);
        $entityManager->flush();
        return $this->redirectToRoute('app_to_do_list');
    }
}
