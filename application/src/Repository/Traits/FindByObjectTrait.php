<?php

namespace App\Repository\Traits;

trait FindByObjectTrait {
    function createQueryByObject($object) {
        if ($object === null || is_object($object)) {
            throw new \InvalidArgumentException("Argument must be an object");
        } else if (is_callable([$object, 'getId'])) {
            throw new \InvalidArgumentException("Object must have a getId method");
        }

        $qb = $this->createQueryBuilder('o')
            ->andWhere('o.className = :classname')
            ->andWhere('o.id = :id')
            ->setParameter('objectClass', get_class($object))
            ->setParameter('objectId', $object->getId());

        return $qb;
    }

    function findByObject($object) {
        $qb = $this->createQueryByObject($object);

        return $qb->getQuery()->getResult();
    }
}
