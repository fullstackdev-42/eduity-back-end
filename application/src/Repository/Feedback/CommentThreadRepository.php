<?php

namespace App\Repository\Feedback;

use App\Entity\Feedback\CommentThread;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CommentThread|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentThread|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentThread[]    findAll()
 * @method CommentThread[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentThreadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentThread::class);
    }

    // /**
    //  * @return CommentThread[] Returns an array of CommentThread objects
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
    public function findOneBySomeField($value): ?CommentThread
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
