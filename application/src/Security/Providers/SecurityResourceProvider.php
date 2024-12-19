<?php

namespace App\Security\Providers;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use App\Entity\ACL\SecurityResource;
use App\Security\Identity\SecurityIdentityInterface;
use App\Security\Identity\SubjectIdentity;
use Doctrine\Common\Collections\Collection;

class SecurityResourceProvider
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var null|EntityRepository
     */
    private $securityResourceRepo;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->em = $entityManager;
    }

    /**
     * @param SubjectIdentity[] $subjects
     * @param SecurityIdentityInterface[] $securityIdentities
     * 
     * @return Collection   
     */
    public function getSecurityResources(array $subjects, array $securityIdentities): Collection
    {
        if (empty($subjects) || empty($securityIdentities)) {
            return [];
        }

        $this->getSecurityResourceRepository();
        $qb = $this->getSecurityResourceRepository()
            ->createQueryBuilder('s')
            ->addSelect('p')
            ->leftJoin('s.permissions', 'p')
            ->orderBy('s.priority', 'asc')
            ->addOrderBy('p.class', 'asc')
            ->addOrderBy('p.field', 'asc')
            ->addOrderBy('p.operation', 'asc');
        
        $qb = $this->addWhereSecurityResources($qb, $subjects, $securityIdentities);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param QueryBuilder $qb
     * @param SubjectIdentity[] $subjects
     * @param SecurityIdentityInterface[] $securityIdentities
     * 
     * @return QueryBuilder
     */

    private function addWhereSecurityResources(QueryBuilder $qb, array $subjects, array $securityIdentities): QueryBuilder
    {
        $parameters = [];
        $i = 0;

        $where = '';
        foreach ($subjects as $i => $subject) {
            $class = 'subject'.$i.'_class';
            $id = 'subject'.$i.'_id';
            $parameters[$class] = $subject->getType();
            $parameters[$id] = $subject->getIdentifier();
            $where .= '' === $where ? '' : ' OR ';
            $where .= sprintf('(s.subjectClass = :%s AND s.subjectId = :%s)', $class, $id);
        }

        $qb->where($where);

        $where = '';
        foreach ($securityIdentities as $type => $identifiers) {
            $qClass = 'sid'.$i.'_class';
            $qIdentifiers = 'sid'.$i.'_ids';
            $parameters[$qClass] = $type;
            $parameters[$qIdentifiers] = $identifiers;
            $where .= '' === $where ? '' : ' OR ';
            $where .= sprintf('(s.identityClass = :%s AND s.identityId = :%s)', $qClass, $qIdentifiers);
            ++$i;
        }

        $qb->andWhere($where);

        foreach ($parameters as $key => $identifiers) {
            $qb->setParameter($key, $identifiers);
        }

        return $qb;
    }

    /**
     * Get the security resource repository.
     *
     * @return EntityRepository
     */
    private function getSecurityResourceRepository(): EntityRepository
    {
        if ($this->securityResourceRepo === null) {
            $this->securityResourceRepo = $this->getRepository(SecurityResource::class);
        }

        return $this->securityResourceRepo;

    }
}