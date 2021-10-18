<?php

namespace App\Repository;

use App\Entity\Client;
use App\Entity\Material;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Material|null find($id, $lockMode = null, $lockVersion = null)
 * @method Material|null findOneBy(array $criteria, array $orderBy = null)
 * @method Material[]    findAll()
 * @method Material[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @extends \Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository<Material>
 */
class MaterialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Material::class);
    }
    
    /*
    * @return array
    * @throws Exception
    * @throws \Doctrine\DBAL\Exception
    */
   public function shareMaterial (string $share): ?array
   {
       $params = [
         ':share' => $this->getEntityManager()->getConnection()->quote($share),
       ];

       $query = ("SELECT * FROM material WHERE material.name LIKE  \"$share%\"");

       return $this->getEntityManager()->getConnection()->executeQuery(strtr($query,$params))->fetchAllAssociative();

   }


}
