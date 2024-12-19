<?php

namespace App\Eduity\ONetBundle\Repository;

use App\Eduity\ONetBundle\Entity\OnetWorkActivities;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method OnetWorkActivities|null find($id, $lockMode = null, $lockVersion = null)
 * @method OnetWorkActivities|null findOneBy(array $criteria, array $orderBy = null)
 * @method OnetWorkActivities[]    findAll()
 * @method OnetWorkActivities[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OnetWorkActivitiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OnetWorkActivities::class);
    }

    public function findActivities() {
        return $this->findActivitiesByImportance(3);
    }

    public function findActivitiesByImportance($mininium = 0) {
        return $this->findActivitiesByScale('IM', $mininium);
    }

    public function findActivitiesByLevel($mininium = 0) {
        return $this->findActivitiesByScale('LV', $mininium);
    }

    public function findActivitiesByScale($scale = null, $mininium = null) {
        $query = $this->buildQueryByScale($scale, $mininium);
            
        return $query->getQuery()->getResult();
    }

    public function buildQueryByScale($scale = null, $mininium = null) {
        $query = $this->createQueryBuilder('a');

        if ($scale === null) {
            // Default to "Important" only, to avoid duplicate records
            $scale = 'IM';
        }

        if ($mininium !== null) {
            $query->andWhere('a.dataValue >= :mininium')
                ->setParameter('mininium', $mininium);
        }

        $query->andWhere('a.scale = :scale')
        ->setParameter('scale', $scale);

        // If they recommend it be suppressed, let it.
        $query->andWhere('a.recommendSuppress = :recommendSuppress')
            ->setParameter('recommendSuppress', 'N');

        return $query;
    }
    
}
