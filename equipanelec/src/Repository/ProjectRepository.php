<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
            user.id = :id and
            project_task.statetask is NULL
            ');

        return $this->getEntityManager()->getConnection()->executeQuery(strtr($query,$params))->fetchAllAssociative();

    }

    public function updateProjectTask(int $idTask, int $idProject,string $description)
    {
        $params = [
            ':idt' => $this->getEntityManager()->getConnection()->quote($idTask),
            ':idp' => $this->getEntityManager()->getConnection()->quote($idProject),
            ':description' => $this->getEntityManager()->getConnection()->quote($description),
        ];
        $query = ('UPDATE project_task
            SET description = :description
            WHERE project_task.project_id = :idp and
            project_task.task_id =:idt');

        $this->getEntityManager()->getConnection()->executeQuery(strtr($query,$params));
        return 'Update successful';
    }

    public function updateProjectTaskState(int $idTask, int $idProject,string $state)
    {
        $params = [
            ':idt' => $this->getEntityManager()->getConnection()->quote($idTask),
            ':idp' => $this->getEntityManager()->getConnection()->quote($idProject),
            ':state' => $this->getEntityManager()->getConnection()->quote($state),
        ];
        $query = ('UPDATE project_task
            SET statetask = :state
            WHERE project_task.project_id = :idp and
            project_task.task_id =:idt');

        $this->getEntityManager()->getConnection()->executeQuery(strtr($query,$params));
        return 'Update successful';
    }



    //Inventory costs
    public function queryCostInventory(int $idProject){
        /*
        $query = $this->getEntityManager()->createQuery('SELECT sum(m.total_cost) from App\Entity\Movement WHERE movement.projects_id = :idP');
        $query->setParameter('idp', $idProject);
        $query->getResult();*/
        $params = [
            ':idp' => $this->getEntityManager()->getConnection()->quote($idProject),
        ];
        $query = ('SELECT SUM(movement.total_cost) AS totalInventory 
                    FROM movement WHERE movement.projects_id= :idp'
        );

        return $this->getEntityManager()->getConnection()->executeQuery(strtr($query,$params))->fetchAllAssociative();


    }


    //Cost of tasks per project
    public function queryCostTask($idProject){
        $params = [
            ':idp' => $this->getEntityManager()->getConnection()->quote($idProject),
        ];
        $query = ('SELECT SUM(task.cost_per_task) AS totalTask
                    FROM task  WHERE task.id IN(
                        SELECT project_task.task_id FROM project_task
                        WHERE project_task.project_id= :idp)'
        );

        return $this->getEntityManager()->getConnection()->executeQuery(strtr($query,$params))->fetchAllAssociative();

    }

    //Count of all project tasks
    public function allTask($idProject){
            $params = [
                ':idp' => $this->getEntityManager()->getConnection()->quote($idProject),
            ];
            $query = ('SELECT COUNT(*) AS taskAll
                        FROM project_task
                        WHERE project_task.project_id = :idp'
            );

            return $this->getEntityManager()->getConnection()->executeQuery(strtr($query,$params))->fetchAllAssociative();

    }
    //Count of completed project tasks
    public function taskFinish($idProject){

                $params = [
                    ':idp' => $this->getEntityManager()->getConnection()->quote($idProject),
                ];
                $query = ('SELECT COUNT(*) AS taskFinish
                            FROM project_task
                            WHERE project_task.project_id = :idp
                            AND project_task.statetask = \'finished\''
                );


                return $this->getEntityManager()->getConnection()->executeQuery(strtr($query,$params))->fetchAllAssociative();

    }

}
