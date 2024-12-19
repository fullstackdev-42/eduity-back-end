<?php

namespace App\Security\Identity;

interface SubjectIdentityInterface extends IdentityInterface
{
    /**
     * Get the instance of subject.
     *
     * @return null|object
     */
    public function getObject();
}
