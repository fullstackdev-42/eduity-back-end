<?php

namespace App\Entity\ACL\Interfaces;

interface PermissionInterface
{
    /**
     * Get the id.
     *
     * @return int
     */
    public function getId();

    /**
     * Set the operation.
     *
     * @param string $operation The operation
     *
     * @return static
     */
    public function setOperation(string $operation);

    /**
     * Get the operation.
     *
     * @return string
     */
    public function getOperation(): string;

    /**
     * Set the permission contexts.
     *
     * @param null|string[] $contexts The permission contexts
     *
     * @return static
     */
    public function setContexts(?array $contexts);

    /**
     * Get the permission contexts.
     *
     * @return null|string[]
     */
    public function getContexts(): ?array;

    /**
     * Set the classname.
     *
     * @param null|string $class The classname
     *
     * @return static
     */
    public function setClass(?string $class);

    /**
     * Get the classname.
     *
     * @return null|string
     */
    public function getClass(): ?string;

    /**
     * Set the field.
     *
     * @param null|string $field The field
     *
     * @return static
     */
    public function setField(?string $field);

    /**
     * Get the field.
     *
     * @return null|string
     */
    public function getField(): ?string;
}
