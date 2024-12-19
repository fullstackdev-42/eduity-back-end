<?php

namespace App\Repository\Traits;

trait FindByGroupTrait {
    public function findByGroup($groupId)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.groups.uuid = :id')
            ->setParameter('id', $groupId)
            ->getQuery()
            ->getResult()
        ;
    }
}
