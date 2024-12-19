<?php

namespace App\Eduity\ONetBundle\Repository;

use App\Eduity\ONetBundle\Entity\OnetOccupationData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method OnetOccupationData|null find($id, $lockMode = null, $lockVersion = null)
 * @method OnetOccupationData|null findOneBy(array $criteria, array $orderBy = null)
 * @method OnetOccupationData[]    findAll()
 * @method OnetOccupationData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OnetOccupationDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OnetOccupationData::class);
    }

    public function findOccupations() {
        return $this->findOccupationsByImportance(3);
    }

    public function findOccupationsByImportance($mininium = null) {
        return $this->findOccupationsByScale('IM', $mininium);
    }

    public function findOccupationsByLevel($mininium = null) {
        return $this->findOccupationsByScale('LV', $mininium);
    }

    public function findOccupationsByScale($scale, $mininium = null) {
        $query = $this->buildQueryByScale($scale, $mininium);

        return $query->getQuery()->getResult();
    }

    public function buildQueryByScale($scale, $mininium = null) {
        $query = $this->createQueryBuilder('o')
            ->innerjoin('o.abilities', 'a');

        if ($scale === null) {
            // Default to "Important" only, to avoid duplicate records
            $scale = 'IM';
        }

        if ($mininium !== null) {
            $query->andWhere('a.dataValue >= :mininium')
                ->setParameter('mininium', $mininium);
        }

        $query->andWhere('a.recommendSuppress = :recommendSuppress')
            ->andWhere('a.scale = :scale')
            ->setParameter('recommendSuppress', 'N')
            ->setParameter('scale', $scale);

        return $query;
    }
}
