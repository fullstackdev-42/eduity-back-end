<?php

namespace App\Eduity\ONetBundle\Repository;

use App\Eduity\ONetBundle\Entity\OnetSkills;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method OnetSkills|null find($id, $lockMode = null, $lockVersion = null)
 * @method OnetSkills|null findOneBy(array $criteria, array $orderBy = null)
 * @method OnetSkills[]    findAll()
 * @method OnetSkills[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OnetSkillsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OnetSkills::class);
    }

    public function findSkills() {
        return $this->findSkillsByImportance(3);
    }

    public function findSkillsByImportance($mininium = null) {
        return $this->findSkillsByScale('IM', $mininium);
    }

    public function findSkillsByLevel($mininium = null) {
        return $this->findSkillsByScale('LV', $mininium);
    }

    public function findSkillsByScale($scale, $mininium = null) {
        $query = $this->buildQueryByScale($scale, $mininium);

        return $query->getQuery()->getResult();
    }

    public function buildQueryByScale($scale, $mininium = null) {
        $query = $this->createQueryBuilder('s');

        if ($scale === null) {
            // Default to "Important" only, to avoid duplicate records
            $scale = 'IM';
        }

        if ($mininium !== null) {
            $query->andWhere('s.dataValue >= :mininium')
                ->setParameter('mininium', $mininium);
        }

        $query->andWhere('s.recommendSuppress = :recommendSuppress')
            ->andWhere('s.scale = :scale')
            ->setParameter('recommendSuppress', 'N')
            ->setParameter('scale', $scale);

        return $query;
    }
    
}
