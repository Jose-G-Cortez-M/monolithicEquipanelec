<?php

namespace App\Repository;

use App\Entity\Tool;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tool|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tool|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tool[]    findAll()
 * @method Tool[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @extends \Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository<Tool>
 */
class ToolRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tool::class);
    }

        /*
    * @return array
    * @throws Exception
    * @throws \Doctrine\DBAL\Exception
    */
   public function shareTool (string $share): ?array
   {
       $params = [
         ':share' => $this->getEntityManager()->getConnection()->quote($share),
       ];

       $query = ("SELECT * FROM tool WHERE tool.name LIKE  \"$share%\"");

       return $this->getEntityManager()->getConnection()->executeQuery(strtr($query,$params))->fetchAllAssociative();

   }

}
