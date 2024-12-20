<?php

namespace App\Repository\ACL;

use App\Entity\ACL\Permission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Permission|null find($id, $lockMode = null, $lockVersion = null)
 * @method Permission|null findOneBy(array $criteria, array $orderBy = null)
 * @method Permission[]    findAll()
 * @method Permission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PermissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Permission::class);
    }

    public function findByPossibleOperations($possibleOperations) {
        return $this->createQueryBuilder('p')
            ->andWhere('p.operation IN (:operations)')
            ->setParameter('operations', $possibleOperations)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @var string $subjectClass The FQCN of the subject
     * @var string subjectId The id of the subject
     */
    public function findBySubject($subjectClass, $subjectId) {
        return $this->createQueryBuilder('p')
            ->andWhere('p.sharingEntries.subjectClass = :subjectClass')
            ->andWhere('p.sharingEntries.subjectId = :subjectId')
            ->setParameter('subjectClass', $subjectClass)
            ->setParameter('subjectId', $subjectId)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @var string $identityClass The FQCN of the Identity
     * @var string identityId The id of the Identity
     */
    public function findByIdentity($identityClass, $identityId) {
        return $this->createQueryBuilder('p')
            ->andWhere('p.sharingEntries.identityClass = :identityClass')
            ->andWhere('p.sharingEntries.identityName = :identityId')
            ->setParameter('identityClass', $identityClass)
            ->setParameter('identityId', $identityId)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Permission[] Returns an array of Permission objects
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
    public function findOneBySomeField($value): ?Permission
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
