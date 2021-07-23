<?php

namespace App\Repository;

use App\Entity\Cable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cable|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cable|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cable[]    findAll()
 * @method Cable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cable::class);
    }

    // /**
    //  * @return Cable[] Returns an array of Cable objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Cable
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
