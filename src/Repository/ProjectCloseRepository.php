<?php

namespace App\Repository;

use App\Entity\ProjectClose;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProjectClose|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectClose|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectClose[]    findAll()
 * @method ProjectClose[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @extends \Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository<ProjectClose>
 */
class ProjectCloseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectClose::class);
    }

    //Active Inventory

    /**
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws Exception
     */
    public function totalInventoryMaterials(): array
    {

        $query = ('SELECT SUM(m.stock*m.purchase_price) AS totalInventoryMaterials FROM material m'
        );
        return $this->getEntityManager()->getConnection()->executeQuery($query)->fetchAllAssociative();

    }

    /**
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws Exception
     */
    public function totalInventoryCables(): array
    {

        $query = ('SELECT SUM(c.availability*c.purchase_price) AS totalInventoryCables FROM cable c'
        );
        return $this->getEntityManager()->getConnection()->executeQuery($query)->fetchAllAssociative();

    }

    /**
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws Exception
     */
    public function totalInventoryTools(): array
    {

        $query = ('SELECT SUM(t.stock*t.price) AS totalInventoryTools FROM tool t'
        );
        return $this->getEntityManager()->getConnection()->executeQuery($query)->fetchAllAssociative();

    }


    //Projects Active

    /**
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws Exception
     */
    public function totalCostProjectTaskActive(): array
    {

        $query = ('SELECT SUM(p.total_cost_task) AS totalCostProjectTaskActive FROM project p'
        );
        return $this->getEntityManager()->getConnection()->executeQuery($query)->fetchAllAssociative();
    }

    public function totalInventoryCostProjectActive(): array
    {

        $query = ('SELECT SUM(p.total_cost_inventory) AS totalInventoryCostProjectActive FROM project p'
        );
        return $this->getEntityManager()->getConnection()->executeQuery($query)->fetchAllAssociative();
    }

    /**
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws Exception
     */
    public function totalCostProjectsActive(): array
    {

        $query = ('SELECT SUM(p.total_cost) AS totalCostProjectActive FROM project p'
        );
        return $this->getEntityManager()->getConnection()->executeQuery($query)->fetchAllAssociative();

    }

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function commercialValueProjectActive(): array
    {

        $query = ('SELECT SUM(p.commercial_value) AS commercialValueProjectActive FROM project p'
        );
        return $this->getEntityManager()->getConnection()->executeQuery($query)->fetchAllAssociative();

    }

    //Projects Closed


    /**
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws Exception
     */
    public function totalCostTaskProjectsClosed(): array
    {

        $query = ('SELECT SUM(pc.total_cost_task) AS totalCostTaskProjectsClosed FROM project_close pc'
        );
        return $this->getEntityManager()->getConnection()->executeQuery($query)->fetchAllAssociative();

    }

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function totalInventoryCostProjectClosed(): array
    {

        $query = ('SELECT SUM(pc.total_cost_inventory) AS totalInventoryCostProjectClosed FROM project_close pc'
        );
        return $this->getEntityManager()->getConnection()->executeQuery($query)->fetchAllAssociative();
    }

    /**
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws Exception
     */
    public function totalCostProjectsClosed(): array
    {

        $query = ('SELECT SUM(pc.total_cost) AS totalCostProjectsClosed FROM project_close pc'
        );
        return $this->getEntityManager()->getConnection()->executeQuery($query)->fetchAllAssociative();

    }


    /**
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws Exception
     */
    public function commercialValueProjectClosed(): array
    {

        $query = ('SELECT SUM(pc.commercial_value) AS commercialValueProjectClosed FROM project_close pc'
        );
        return $this->getEntityManager()->getConnection()->executeQuery($query)->fetchAllAssociative();

    }


    //Projects Active por filter

    /**
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws Exception
     */
    public function totalCostProjectsActiveFilter($startDate, $endDate): array
    {

        $params = [
            ':startDate' => $this->getEntityManager()->getConnection()->quote($startDate),
            ':endDate' => $this->getEntityManager()->getConnection()->quote($endDate)

        ];
        $query = ('SELECT SUM(p.total_cost) AS totalCostProjectActive
                    FROM project p
                    WHERE p.registration_date BETWEEN :startDate  AND :endDate'
        );
        return $this->getEntityManager()->getConnection()->executeQuery(strtr($query,$params))->fetchAllAssociative();
    }

    /**
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws Exception
     */
    public function commercialValueClosedFilter($startDate, $endDate): array
    {

        $params = [
            ':startDate' => $this->getEntityManager()->getConnection()->quote($startDate),
            ':endDate' => $this->getEntityManager()->getConnection()->quote($endDate)

        ];
        $query = ('SELECT SUM(pc.total_cost) AS commercialValueProjectClosed
                    FROM project_close pc
                    WHERE pc.registration_date BETWEEN :startDate  AND :endDate'
        );
        return $this->getEntityManager()->getConnection()->executeQuery(strtr($query,$params))->fetchAllAssociative();
    }

    /**
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws Exception
     */
    public function totalCostClosedFilter($startDate, $endDate):array
    {

        $params = [
            ':startDate' => $this->getEntityManager()->getConnection()->quote($startDate),
            ':endDate' => $this->getEntityManager()->getConnection()->quote($endDate)

        ];
        $query = ('SELECT SUM(pc.commercial_value) AS totalCostProjectsClosed
                    FROM project_close pc
                    WHERE pc.registration_date BETWEEN :startDate  AND :endDate'
        );
        return $this->getEntityManager()->getConnection()->executeQuery(strtr($query,$params))->fetchAllAssociative();
    }










    // /**
    //  * @return ProjectClose[] Returns an array of ProjectClose objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProjectClose
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
