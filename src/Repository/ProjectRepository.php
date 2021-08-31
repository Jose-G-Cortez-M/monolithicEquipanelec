<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Driver\Exception;
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

    // list of tasks per user that are not finished

    /**
     * @param int $value
     * @return array
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function taskPerUser (int $value): ?array
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

    //task observation update by project

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function updateProjectTask(int $idTask, int $idProject, string $description): string
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

    //task observation by project

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function observationProjectTask(int $idTask, int $idProject): array
    {
        $params = [
            ':idt' => $this->getEntityManager()->getConnection()->quote($idTask),
            ':idp' => $this->getEntityManager()->getConnection()->quote($idProject)
        ];
        $query = ('SELECT pt.description FROM project_task pt
            WHERE pt.project_id = :idp and
            pt.task_id = :idt');

        return $this->getEntityManager()->getConnection()->executeQuery(strtr($query,$params))->fetchAllAssociative();

    }

    //task status update by project

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function updateProjectTaskState(int $idTask, int $idProject, string $state): string
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

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function queryCostInventory(int $idProject): array
    {
        $params = [
            ':idp' => $this->getEntityManager()->getConnection()->quote($idProject),
        ];
        $query = ('SELECT SUM(movement.total_cost) AS totalInventory 
                    FROM movement WHERE movement.projects_id = :idp'
        );

        return $this->getEntityManager()->getConnection()->executeQuery(strtr($query,$params))->fetchAllAssociative();


    }


    /**
     * @throws \Doctrine\DBAL\Exception
     * @throws Exception
     */
    public function queryCommercialInventory(int $idProject): array
    {
        $params = [
            ':idp' => $this->getEntityManager()->getConnection()->quote($idProject),
        ];
        $query = ('SELECT SUM(movement.total_cost) AS totalInventory 
                    FROM movement WHERE movement.projects_id= :idp'
        );

        return $this->getEntityManager()->getConnection()->executeQuery(strtr($query,$params))->fetchAllAssociative();


    }

    //Cost of tasks per project

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function queryCostTask($idProject): array
    {
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

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function allTask($idProject): array
    {
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

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function taskFinish($idProject): array
    {

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
    

    //Inventory costs per material

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function costMaterialPerProject(int $idProject): array
    {
        $params = [
            ':idp' => $this->getEntityManager()->getConnection()->quote($idProject),
        ];
        $query = ('SELECT m.order_date,ma.name,ma.sale_price as unit_cost,m.quantity,m.total_cost 
                   FROM movement m, material ma 
                   WHERE m.projects_id = :idp AND m.materials_id IS NOT NULL AND m.materials_id = ma.id'
        );

        return $this->getEntityManager()->getConnection()->executeQuery(strtr($query,$params))->fetchAllAssociative();

    }

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function costToolPerProject(int $idProject): array
    {
        $params = [
            ':idp' => $this->getEntityManager()->getConnection()->quote($idProject),
        ];
        $query = ('SELECT m.order_date,t.name,t.price as unit_cost, m.quantity, m.total_cost 
                    FROM movement m, tool t 
                    WHERE m.projects_id = :idp AND m.tools_id IS NOT NULL AND m.tools_id=t.id'
        );
        return $this->getEntityManager()->getConnection()->executeQuery(strtr($query,$params))->fetchAllAssociative();

    }

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function costCablePerProject(int $idProject): array
    {
        $params = [
            ':idp' => $this->getEntityManager()->getConnection()->quote($idProject),
        ];
        $query = ('SELECT m.order_date,c.name,c.sale_price as meter_cost, m.quantity, m.total_cost 
                    FROM movement m, cable c 
                    WHERE m.projects_id = :idp AND m.cables_id IS NOT NULL AND m.cables_id=c.id'
        );
        return $this->getEntityManager()->getConnection()->executeQuery(strtr($query,$params))->fetchAllAssociative();

    }


    //All task end project

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function allTaskEndProject($idProject): array
    {
        $params = [
            ':idp' => $this->getEntityManager()->getConnection()->quote($idProject),
        ];
        $query = ('SELECT t.name, t.cost_per_task
                        FROM project_task pt, task t
                        WHERE pt.project_id = :idp AND 
                        pt.task_id = t.id'
        );

        return $this->getEntityManager()->getConnection()->executeQuery(strtr($query,$params))->fetchAllAssociative();

    }

    //Show observation per project task

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function showObservationProjectTask($idProject): array
    {
        $params = [
            ':idp' => $this->getEntityManager()->getConnection()->quote($idProject),
        ];
        $query = ('SELECT p.name AS project,t.name, pt.description FROM project p, project_task pt, task t 
                    WHERE p.id=pt.project_id AND t.id=pt.task_id AND p.id = :idp'
        );

        return $this->getEntityManager()->getConnection()->executeQuery(strtr($query,$params))->fetchAllAssociative();

    }



}
