<?php
namespace App\EventSubscriber\Jobmap;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\EventListener\EventPriorities;
use Fxp\Component\Security\Identity\SubjectIdentity;
use Fxp\Component\Security\Identity\GroupSecurityIdentity;
use App\Repository\ACL\PermissionRepository;
use App\Entity\Jobmap\Organization;
use App\Entity\Jobmap\Inventory;
use App\Entity\ACL\Sharing;
use App\Entity\ACL\Group;
use App\Entity\ACL\Permission;

final class InventorySubscriber implements EventSubscriberInterface
{
    /* @var EntityManagerInterface $entityManager */
    private $entityManager;

    private $permissions;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['newInventory', EventPriorities::PRE_WRITE]
        ];
    }

    public function newInventory(ViewEvent $event) 
    {
        $inventory = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$inventory instanceof Inventory || Request::METHOD_POST !== $method) {
            return;
        }

        //$inventory = $this->persistInventory($inventory);

        // $groups = [];
        // //create default groups for organization
        // foreach (Organization::$defaultGroupNames as $groupName) {
        //     $group = new Group();
        //     $group->setSubjectClass(Organization::class)
        //         ->setSubjectId($organization->getId())
        //         ->setName($groupName);
        //     $groups[$groupName] = $group;
        //     $this->entityManager->persist($group);
        // }
        // $this->entityManager->flush();

    }

}