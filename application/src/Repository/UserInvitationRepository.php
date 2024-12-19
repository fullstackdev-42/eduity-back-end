<?php

namespace App\Repository;

use App\Entity\UserInvitation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserInvitation|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserInvitation|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserInvitation[]    findAll()
 * @method UserInvitation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserInvitationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserInvitation::class);
    }

    public function findByUserOrEmailAndOrganization($user, $email, $organization)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.user = :user OR u.email = :email')
            ->andWhere('u.organization = :org')
            ->setParameter('org', $organization)
            ->setParameter('user', $user)
            ->setParameter('email', $email)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return UserInvitation[] Returns an array of UserInvitation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserInvitation
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
