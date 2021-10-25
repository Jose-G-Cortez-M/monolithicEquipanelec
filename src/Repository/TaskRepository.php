<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @extends \Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }
    /*
    * @return array
    * @throws Exception
    * @throws \Doctrine\DBAL\Exception
    */
   public function shareTask (string $share): ?array
   {
       $params = [
         ':share' => $this->getEntityManager()->getConnection()->quote($share),
       ];

       $query = ("SELECT * FROM task WHERE task.name LIKE  \"$share%\"");

       return $this->getEntityManager()->getConnection()->executeQuery(strtr($query,$params))->fetchAllAssociative();

   }

}
