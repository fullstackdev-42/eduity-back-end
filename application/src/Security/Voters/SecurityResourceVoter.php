<?php

namespace App\Security\Voters;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use App\Security\Managers\SecurityIdentityManager;
use App\Security\Managers\SecurityResourceManager;
use App\Security\Identity\SubjectIdentity;
use App\Entity\User;

final class SecurityResourceVoter extends Voter
{

    /**
     * @var SecurityResourceManager
     */
    private $securityResourceManager;

    /**
     * @var SecurityIdentityManager
     */
    private $securityIdentityManager;
    
    public function __construct(SecurityResourceManager $securityResourceManager,
        SecurityIdentityManager $securityIdentityManager) 
    {
        $this->$securityResourceManager = $securityResourceManager;
        $this->$securityIdentityManager = $securityIdentityManager;
    }


    protected function supports($attribute, $subject): bool
    {
        return $this->isAttributeSupported($attribute)
            && $this->isSubjectSupported($subject);
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $securityIdentities = $this->securityIdentityManager->getSecurityIdentities();
        $attribute = strtolower(substr($attribute, 5));
        return $this->securityResourceManager->isGranted($securityIdentities, $attribute, $subject);
    }

    private function isAttributeSupported($attribute): bool
    {
        return \is_string($attribute) && 0 === stripos(strtolower($attribute), 'perm_');
    }

    private function isSubjectSupported($subject): bool
    {
        if (null === $subject || \is_string($subject) || \is_object($subject)) {
            return true;
        }

        return false;
    }
}