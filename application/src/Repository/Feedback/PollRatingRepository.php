<?php

namespace App\Repository\Feedback;

use App\Entity\Feedback\PollRating;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PollRating|null find($id, $lockMode = null, $lockVersion = null)
 * @method PollRating|null findOneBy(array $criteria, array $orderBy = null)
 * @method PollRating[]    findAll()
 * @method PollRating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PollRatingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PollRating::class);
    }

    // /**
    //  * @return PollRating[] Returns an array of PollRating objects
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
    public function findOneBySomeField($value): ?PollRating
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
