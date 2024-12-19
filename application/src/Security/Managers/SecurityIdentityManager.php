<?php

namespace App\Security\Managers;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use App\Security\Identity\SecurityIdentityInterface;
use App\Security\Identity\GroupSecurityIdentity;
use App\Security\Identity\UserSecurityIdentity;

class SecurityIdentityManager
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(TokenStorageInterface  $tokenStorage) {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @return SecurityIdentityInterface[]
     */
    public function getSecurityIdentities(): array
    {
        $securityIdentities = [];

        if (!$this->tokenStorage instanceof AnonymousToken) {
            $securityIdentities[] = UserSecurityIdentity::fromToken($this->tokenStorage);
            //add groups
            array_merge($securityIdentities, GroupSecurityIdentity::fromToken($this->tokenStorage));
        }

        return $securityIdentities;
    }

    public function __toString()
    {
        return "why is this needed???";
    }
}