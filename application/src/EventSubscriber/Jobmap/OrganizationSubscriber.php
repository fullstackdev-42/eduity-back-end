<?php
namespace App\EventSubscriber\Jobmap;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\EventListener\EventPriorities;
use App\Security\Identity\SubjectIdentity;
use App\Security\Identity\GroupSecurityIdentity;
use App\Repository\ACL\PermissionRepository;
use App\Entity\Jobmap\Organization;
use App\Entity\ACL\Group;
use App\Entity\ACL\Permission;
use App\Entity\ACL\SecurityOrganization;
use App\Entity\ACL\SecurityResource;

final class OrganizationSubscriber implements EventSubscriberInterface
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
            KernelEvents::VIEW => ['newOrganization', EventPriorities::POST_WRITE]
        ];
    }

    public function newOrganization(ViewEvent $event) 
    {
        $organization = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$organization instanceof Organization || Request::METHOD_POST !== $method) {
            return;
        }

        /**
         * @var SecurityOrganization $secOrg
         */
        $secOrg = $organization->getSecurityOrganization();

        $secOrg->addUser($organization->getOwner());
        

        $groups = [];
        //create default groups for organization
        $i = 1;
        foreach (SecurityOrganization::$defaultGroupNames as $groupName) {
            $group = new Group($secOrg);
            $group->setName($groupName)
                ->setPriority($i);
            $groups[$groupName] = $group;
            $this->entityManager->persist($group);
            $i++;
        }
        $this->entityManager->persist($secOrg);
        $this->entityManager->flush();

        $organizationIdentity = SubjectIdentity::fromObject($organization);    
        foreach ($groups as $group) {
            $groupIdentity = GroupSecurityIdentity::fromAccount($group);

            $secResource = (new SecurityResource())
                ->setSubjectClass($organizationIdentity->getType())
                ->setSubjectId($organizationIdentity->getIdentifier())
                ->setIdentityClass($groupIdentity->getType())
                ->setIdentityId($groupIdentity->getIdentifier())
                ->setPriority(1);
                
            switch (strtolower($group->getName())) {
                case 'sponsor':
                    $this->addPermissionsForSponsors($secResource);
                    //add owner to sponser ACL group
                    $organization->getOwner()->addGroup($group);
                    break;
                case 'leader':
                    $this->addPermissionsForLeaders($secResource);
                    break;
                case 'contributor':
                    $this->addPermissionsForContributors($secResource);
                    break;
                case 'reviewer':
                    $this->addPermissionsForReviewers($secResource);
                    break;
                case 'public':
                    $this->addPermissionsForPublic($secResource);
                    break;
            }

            $this->entityManager->persist($secResource);
        }

        $this->entityManager->flush();
    }

    private function addPermissionsForSponsors(SecurityResource $secResource)
    {
        $secResource->addPermission($this->getPermissionByOperation('read'));
        $secResource->addPermission($this->getPermissionByOperation('edit'));
        $secResource->addPermission($this->getPermissionByOperation('create'));
        $secResource->addPermission($this->getPermissionByOperation('delete'));
        $secResource->addPermission($this->getPermissionByOperation('grant'));
        $secResource->addPermission($this->getPermissionByOperation('share'));
        $secResource->addPermission($this->getPermissionByOperation('feedback'));
        $secResource->addPermission($this->getPermissionByOperation('invite'));
    }

    private function addPermissionsForLeaders(SecurityResource $secResource)
    {
        $secResource->addPermission($this->getPermissionByOperation('read'));
        $secResource->addPermission($this->getPermissionByOperation('edit'));
        $secResource->addPermission($this->getPermissionByOperation('create'));
        $secResource->addPermission($this->getPermissionByOperation('delete'));
        $secResource->addPermission($this->getPermissionByOperation('grant'));
        $secResource->addPermission($this->getPermissionByOperation('share'));
        $secResource->addPermission($this->getPermissionByOperation('feedback'));
    }

    private function addPermissionsForContributors(SecurityResource $secResource)
    {
        $secResource->addPermission($this->getPermissionByOperation('read'));
        $secResource->addPermission($this->getPermissionByOperation('edit'));
        $secResource->addPermission($this->getPermissionByOperation('create'));
        $secResource->addPermission($this->getPermissionByOperation('delete'));
        $secResource->addPermission($this->getPermissionByOperation('feedback'));
    }

    private function addPermissionsForReviewers(SecurityResource $secResource)
    {
        $secResource->addPermission($this->getPermissionByOperation('read'));
        $secResource->addPermission($this->getPermissionByOperation('feedback'));
    }

    private function addPermissionsForPublic(SecurityResource $secResource)
    {
        $secResource->addPermission($this->getPermissionByOperation('read'));
    }

    private function getPermissionByOperation(string $operation) : ?Permission 
    {
        if ($this->permissions === null) {
            //prefetch permissions that will be used;

            /** @var PermissionRepository $permissionRepository */
            $permissionRepository = $this->entityManager->getRepository(Permission::class);
            $this->permissions = $permissionRepository->findByPossibleOperations(['read', 'edit', 'create', 'delete', 'grant', 'share', 'feedback', 'invite']);
        } 

        /** @var Permission $perm */
        foreach ($this->permissions as $perm) {
            if ($perm->getOperation() === $operation) {
                return $perm;
            }
        }
        return null;
    }

}