<?php

namespace App\Security\Identity;

abstract class AbstractBaseIdentity implements IdentityInterface
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $identifier;

    /**
     * Constructor.
     *
     * @param string $identifier The identifier
     * @param string $type       The type
     *
     * @throws InvalidArgumentException When the identifier is empty
     * @throws InvalidArgumentException When the type is empty
     */
    public function __construct(?string $type, ?string $identifier)
    {
        if (empty($type)) {
            throw new \InvalidArgumentException('The type cannot be empty');
        }

        if (empty($identifier)) {
            throw new \InvalidArgumentException('The identifier cannot be empty');
        }

        $this->type = $type;
        $this->identifier = $identifier;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function equals(IdentityInterface $identity): bool
    {
        return $this->identifier === $identity->getIdentifier()
               && $this->type === $identity->getType();
    }
}