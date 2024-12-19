<?php

namespace App\Entity\ACL\Interfaces;

interface SecurityResourceInterface extends PermissionsInterface
{
    /**
     * Get the id.
     *
     * @return int
     */
    public function getId();

    /**
     * Set the classname of subject.
     *
     * @param string $class The classname
     *
     * @return static
     */
    public function setSubjectClass(string $class);

    /**
     * Get the classname of subject.
     *
     * @return string
     */
    public function getSubjectClass(): string;

    /**
     * Set the id of subject.
     *
     * @param int $id The id
     *
     * @return static
     */
    public function setSubjectId(int $id);

    /**
     * Get the id of subject.
     *
     * @return int
     */
    public function getSubjectId(): int;

    /**
     * Set the classname of identity.
     *
     * @param string $class The classname
     *
     * @return static
     */
    public function setIdentityClass(string $class);

    /**
     * Get the classname of identity.
     *
     * @return string
     */
    public function getIdentityClass(): string;

    /**
     * Set the unique id of identity.
     *
     * @param string $id The unique id
     *
     * @return static
     */
    public function setIdentityId(int $id);

    /**
     * Get the unique id of identity.
     *
     * @return int
     */
    public function getIdentityId(): int;

    /**
     * Get the value of allowance
     *
     * @return  null|bool
     */ 
    public function getAllowance(): ?bool;

    /**
     * Set the value of allowance
     *
     * @param  null|bool  $allowance
     *
     * @return  static
     */ 
    public function setAllowance(?bool $allowance);
}
