<?php

namespace App\EventSubscriber\Doctrine;

use Doctrine\Persistence\Event\LifecycleEventArgs;
use Ramsey\Uuid\Provider\Node\RandomNodeProvider;
use Ramsey\Uuid\Uuid;

final class GenerateUUIDLifecycle
{

    public function prePersist(LifecycleEventArgs $args): void    
    {
        $entity = $args->getObject();
        if (!property_exists($entity, 'uuid')) {
            return;
        }

        if ($entity->getUuid() === null) {
            $randomNodeProvider = new RandomNodeProvider();
            $entity->setUuid(Uuid::uuid6($randomNodeProvider->getNode()));
        }
        
    }
}