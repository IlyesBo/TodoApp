<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(TaskRepository $taskRepository, Request $request): Response
    {
        // Récupère le filtre depuis la requête (si présent)
        $filter = $request->query->get('filter', 'all');

        // Récupère les tâches en fonction du filtre
        if ($filter === 'completed') {
            $tasks = $taskRepository->findBy(['status' => true]);
        } elseif ($filter === 'pending') {
            $tasks = $taskRepository->findBy(['status' => false]);
        } else {
            $tasks = $taskRepository->findAll();
        }

        return $this->render('home/index.html.twig', [
            'tasks' => $tasks,
            'filter' => $filter,
        ]);
    }
}
