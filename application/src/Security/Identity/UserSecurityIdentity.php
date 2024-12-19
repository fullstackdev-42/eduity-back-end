<?php

namespace App\Security\Identity;

use App\Utils\ClassUtils;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use App\Entity\User;

final class UserSecurityIdentity extends AbstractBaseIdentity implements SecurityIdentityInterface
{
    /**
     * Creates a user security identity from a UserInterface.
     *
     * @param User $user The user
     *
     * @return UserSecurityIdentity
     */
    public static function fromAccount(User $user): UserSecurityIdentity
    {
        return new self(ClassUtils::getClass($user), $user->getId());
    }

    /**
     * Creates a user security identity from a TokenInterface.
     *
     * @param TokenInterface $token The token
     *
     * @throws InvalidArgumentException When the user class not implements "Symfony\Component\Security\Core\User\UserInterface"
     *
     * @return UserSecurityIdentity
     */
    public static function fromToken(TokenInterface $token): UserSecurityIdentity
    {
        $user = $token->getUser();

        if ($user instanceof User) {
            return self::fromAccount($user);
        }

        throw new \InvalidArgumentException('The user class must implement "Symfony\Component\Security\Core\User\UserInterface"');
    }
}
