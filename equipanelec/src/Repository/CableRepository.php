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
 * @extends \Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository<Cable>
 */
class CableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cable::class);
    }


}
