<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 *
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * Trouve les tâches filtrées par statut.
     *
     * @param string $filter Le filtre à appliquer ('all', 'completed', 'pending')
     * @return Task[] Retourne un tableau de tâches
     */
    public function findByStatus(string $filter): array
    {
        $queryBuilder = $this->createQueryBuilder('t');

        if ($filter === 'completed') {
            $queryBuilder->andWhere('t.status = :status')
                          ->setParameter('status', true);
        } elseif ($filter === 'pending') {
            $queryBuilder->andWhere('t.status = :status')
                          ->setParameter('status', false);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Marque une tâche comme terminée.
     *
     * @param Task $task La tâche à marquer comme terminée
     */
    public function markAsCompleted(Task $task): void
    {
        $task->setStatus(true);
        $this->getEntityManager()->flush();
    }

    /**
     * Supprime une tâche.
     *
     * @param Task $task La tâche à supprimer
     */
    public function remove(Task $task, bool $flush = true): void
    {
        $this->getEntityManager()->remove($task);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Sauvegarde une tâche (création ou mise à jour).
     *
     * @param Task $task La tâche à sauvegarder
     * @param bool $flush Si true, exécute un flush pour persister en base de données
     */
    public function save(Task $task, bool $flush = true): void
    {
        $this->getEntityManager()->persist($task);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}