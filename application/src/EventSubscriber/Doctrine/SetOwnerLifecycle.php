<?php

namespace App\EventSubscriber\Doctrine;

use Symfony\Component\Security\Core\Security;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\Interfaces\OwnerableInterface;

final class SetOwnerLifecycle
{
    /** @var Security $security */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    public function prePersist(LifecycleEventArgs $args): void    
    {
        $entity = $args->getObject();
        if (!$entity instanceof OwnerableInterface) {
            return;
        }

        if ($entity->getOwner() === null) {
            $entity->setOwner($this->security->getUser());
        }
        
    }
}