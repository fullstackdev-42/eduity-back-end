<?php

namespace App\Repository\Feedback;

use App\Entity\Feedback\Poll;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Poll|null find($id, $lockMode = null, $lockVersion = null)
 * @method Poll|null findOneBy(array $criteria, array $orderBy = null)
 * @method Poll[]    findAll()
 * @method Poll[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PollRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Poll::class);
    }

    // /**
    //  * @return Poll[] Returns an array of Poll objects
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
    public function findOneBySomeField($value): ?Poll
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
