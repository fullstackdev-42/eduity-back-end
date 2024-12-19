<?php

namespace App\Repository\Jobmap;

use App\Entity\Jobmap\OrganizationLocation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method OrganizationLocation|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrganizationLocation|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrganizationLocation[]    findAll()
 * @method OrganizationLocation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrganizationLocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrganizationLocation::class);
    }

    // /**
    //  * @return OrganizationLocation[] Returns an array of OrganizationLocation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrganizationLocation
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
