<?php

namespace App\Eduity\ONetBundle\Repository;

use App\Eduity\ONetBundle\Entity\OnetAbilities;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method OnetAbilities|null find($id, $lockMode = null, $lockVersion = null)
 * @method OnetAbilities|null findOneBy(array $criteria, array $orderBy = null)
 * @method OnetAbilities[]    findAll()
 * @method OnetAbilities[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OnetAbilitiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OnetAbilities::class);
    }

    public function findAbilities() {
        return $this->findAbilitiesByImportance(3);
    }

    public function findAbilitiesByImportance($mininium = 0) {
        return $this->findAbilitiesByScale('IM', $mininium);
    }

    public function findAbilitiesByLevel($mininium = 0) {
        return $this->findAbilitiesByScale('LV', $mininium);
    }

    public function findAbilitiesByScale($scale = null, $mininium = null) {
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
