<?php

namespace App\Security\Managers;

use App\Security\Providers\SecurityResourceProvider;
use App\Entity\ACL\Interfaces\SecurityResourceInterface;
use App\Entity\ACL\Interfaces\PermissionInterface;

class SecurityResourceManager
{
    /**
     * @var SecurityResourceProvider    
     */
    private $securityResourceProvider;

    public function __construct(SecurityResourceProvider $securityResourceProvider) {
        $this->securityResourceProvider = $securityResourceProvider;
    }

    public function isGranted($securityIdentities, $attribute, $subject)
    {
        $securityResources = $this->securityResourceProvider->getSecurityResources([$subject], $securityIdentities);

        /** 
         * @var SecurityResourceInterface $resource
         */
        foreach ($securityResources as $resource) {
            if ($resource->getAllowance() === true) {
                /**
                 * @var PermissionInterface $perm
                 */
                foreach ($resource->getPermissions() as $perm) {
                    if ($perm->getOperation() === $attribute) {
                        return true;
                    }
                }
            } else if ($resource->getAllowance() === false) {
                //first "deny" takes predence
                return false;
            }
        }
    }

    public function __toString()
    {
        return "why is this needed???";
    }
}