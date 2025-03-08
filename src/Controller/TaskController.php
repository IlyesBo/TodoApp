<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/task')]
class TaskController extends AbstractController
{
    #[Route('/', name: 'app_task_index', methods: ['GET'])]
    public function index(TaskRepository $taskRepository, Request $request): Response
    {
        // Récupère le filtre depuis la requête (si présent)
        $filter = $request->query->get('filter', 'all');

        // Récupère les tâches en fonction du filtre
        $tasks = $taskRepository->findByStatus($filter);

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
            'filter' => $filter,
        ]);
    }

    #[Route('/new', name: 'app_task_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TaskRepository $taskRepository): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $taskRepository->save($task, true);

            // Message flash pour confirmer la création
            $this->addFlash('success', 'Tâche créée avec succès !');

            // Redirection vers la liste des tâches
            return $this->redirectToRoute('app_task_index');
        }

        return $this->render('task/new.html.twig', [
            'task' => $task,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_task_show', methods: ['GET'])]
    public function show(Task $task): Response
    {
        return $this->render('task/show.html.twig', [
            'task' => $task,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_task_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Task $task, TaskRepository $taskRepository): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $taskRepository->save($task, true);

            // Message flash pour confirmer la modification
            $this->addFlash('success', 'Tâche mise à jour avec succès !');

            // Redirection vers la liste des tâches
            return $this->redirectToRoute('app_task_index');
        }

        return $this->render('task/edit.html.twig', [
            'task' => $task,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_task_delete', methods: ['POST'])]
    public function delete(Request $request, Task $task, TaskRepository $taskRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$task->getId(), $request->request->get('_token'))) {
            $taskRepository->remove($task, true);

            // Message flash pour confirmer la suppression
            $this->addFlash('success', 'Tâche supprimée avec succès !');
        }

        // Redirection vers la liste des tâches
        return $this->redirectToRoute('app_task_index');
    }

    #[Route('/{id}/complete', name: 'app_task_mark_completed', methods: ['POST'])]
    public function markAsCompleted(Request $request, Task $task, TaskRepository $taskRepository): Response
    {
        if ($this->isCsrfTokenValid('complete'.$task->getId(), $request->request->get('_token'))) {
            $taskRepository->markAsCompleted($task);

            // Message flash pour confirmer le marquage comme terminé
            $this->addFlash('success', 'Tâche marquée comme terminée !');
        }

        // Redirection vers la liste des tâches
        return $this->redirectToRoute('app_task_index');
    }
}