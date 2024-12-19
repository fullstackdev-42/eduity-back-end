<?php

namespace App\Eduity\ONetBundle\Repository;

use App\Eduity\ONetBundle\Entity\OnetWorkContext;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method OnetWorkContext|null find($id, $lockMode = null, $lockVersion = null)
 * @method OnetWorkContext|null findOneBy(array $criteria, array $orderBy = null)
 * @method OnetWorkContext[]    findAll()
 * @method OnetWorkContext[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OnetWorkContextRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OnetWorkContext::class);
    }

    public function findWorkcontexts() {
        return $this->findWorkcontextsByContext();
    }

    public function findWorkcontextsByContext($mininium = 0) {
        return $this->findWorkcontextsByScale('CX', $mininium);
    }

    public function findWorkcontextsByScale($scale = null, $mininium = null) {
        $query = $this->buildQueryByScale($scale, $mininium);
            
        return $query->getQuery()->getResult();
    }

    public function buildQueryByScale($scale = null, $mininium = null) {
        $query = $this->createQueryBuilder('w');

        if ($scale === null) {
            // Default to "Important" only, to avoid duplicate records
            $scale = 'CX';
        }

        if ($mininium !== null) {
            $query->andWhere('w.dataValue >= :mininium')
                ->setParameter('mininium', $mininium);
        }

        $query->andWhere('w.scale = :scale')
        ->setParameter('scale', $scale);

        // If they recommend it be suppressed, let it.
        $query->andWhere('w.recommendSuppress = :recommendSuppress')
            ->setParameter('recommendSuppress', 'N');

        return $query;
    }
    
}
