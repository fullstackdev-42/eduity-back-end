<?php

namespace App\Security\Identity;

use App\Utils\ClassUtils;
use App\Entity\ACL\Interfaces\GroupInterface;
use App\Entity\ACL\Interfaces\GroupableInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

final class GroupSecurityIdentity extends AbstractBaseIdentity implements SecurityIdentityInterface
{
    /**
     * Creates a group security identity from a GroupInterface.
     *
     * @param GroupInterface $group The group
     *
     * @return static
     */
    public static function fromAccount(GroupInterface $group): self
    {
        return new self(ClassUtils::getClass($group), $group->getId());
    }

    /**
     * Creates a group security identity from a TokenInterface.
     *
     * @param TokenInterface $token The token
     *
     * @throws InvalidArgumentException When the user class not implements "App\Entity\ACL\Interfaces\GroupableInterface"
     *
     * @return static[]
     */
    public static function fromToken(TokenInterface $token): array
    {
        $user = $token->getUser();

        if ($user instanceof GroupableInterface) {
            $sids = [];
            $groups = $user->getGroups();

            foreach ($groups as $group) {
                $sids[] = self::fromAccount($group);
            }

            return $sids;
        }

        throw new \InvalidArgumentException('The user class must implement "App\Entity\ACL\Interfaces\GroupableInterface"');
    }
}
