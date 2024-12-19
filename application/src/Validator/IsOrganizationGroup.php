<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"CLASS"})
 */
class IsOrganizationGroup extends Constraint {

    public $message = 'Cannot set groups that are not contained within the organization.';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}