<?php

namespace App\Repository\ACL;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\Traits\FindBySubjectTrait;
use App\Entity\ACL\SecurityResource;

/**
 * @method SecurityResource|null find($id, $lockMode = null, $lockVersion = null)
 * @method SecurityResource|null findOneBy(array $criteria, array $orderBy = null)
 * @method SecurityResource[]    findAll()
 * @method SecurityResource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SecurityResourceRepository extends ServiceEntityRepository
{
    use FindBySubjectTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SecurityResource::class);
    }

    // /**
    //  * @return SecurityResource[] Returns an array of SecurityResource objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value):  SecurityResource
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
