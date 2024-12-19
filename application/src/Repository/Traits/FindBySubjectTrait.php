<?php

namespace App\Repository\Traits;

trait FindBySubjectTrait {
    /**
     * @var string $subjectClass The FQCN of the subject
     * @var string subjectId The id of the subject
     */
    public function findBySubject($subjectClass, $subjectId) {
        return $this->createQueryBuilder('g')
            ->andWhere('g.subjectClass = :subjectClass')
            ->andWhere('g.subjectId = :subjectId')
            ->setParameter('subjectClass', $subjectClass)
            ->setParameter('subjectId', $subjectId)
            ->getQuery()
            ->getResult()
        ;
    }
}