<?php

namespace App\Repository\Feedback;

use App\Entity\Feedback\PollOption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PollOption|null find($id, $lockMode = null, $lockVersion = null)
 * @method PollOption|null findOneBy(array $criteria, array $orderBy = null)
 * @method PollOption[]    findAll()
 * @method PollOption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PollOptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PollOption::class);
    }

    // /**
    //  * @return PollOption[] Returns an array of PollOption objects
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
    public function findOneBySomeField($value): ?PollOption
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
