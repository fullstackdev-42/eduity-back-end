<?php

namespace App\Repository\ACL;

use App\Entity\ACL\SecurityOrganization;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\Traits\FindBySubjectTrait;

/**
 * @method SecurityOrganization|null find($id, $lockMode = null, $lockVersion = null)
 * @method SecurityOrganization|null findOneBy(array $criteria, array $orderBy = null)
 * @method SecurityOrganization[]    findAll()
 * @method SecurityOrganization[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SecurityOrganizationRepository extends ServiceEntityRepository
{
   
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SecurityOrganization::class);
    }

    // /**
    //  * @return SecurityOrganization[] Returns an array of SecurityOrganization objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SecurityOrganization
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
