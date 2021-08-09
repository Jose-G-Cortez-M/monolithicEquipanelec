<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @extends \Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository<Project>
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }
    public function taskPerUser (int $value)
    {
        $params = [
          ':id' => $this->getEntityManager()->getConnection()->quote($value),
        ];

        $query = ('SELECT project.id as idp, 
            project.name as project, project.description as desproject,
            task.id as idt, task.name
            from user, project, project_user,project_task,task 
            WHERE user.id = project_user.user_id and 
            project.id = project_user.project_id and 
            project.id = project_task.project_id and 
            project_task.task_id = task.id and 
            user.id = :id');

        return $this->getEntityManager()->getConnection()->executeQuery(strtr($query,$params))->fetchAllAssociative();

    }

    public function updateProjectTask(int $idTask, int $idProject,string $description)
    {
        $params = [
            ':idt' => $this->getEntityManager()->getConnection()->quote($idTask),
            ':idp' => $this->getEntityManager()->getConnection()->quote($idProject),
            ':description' => $this->getEntityManager()->getConnection()->quote($description),
        ];
        $query = ("UPDATE project_task
            SET description = :description
            WHERE project_task.project_id = :idp and
            project_task.task_id =:idt");

        $this->getEntityManager()->getConnection()->executeQuery(strtr($query,$params));
        return 'Update successful';
    }


}
