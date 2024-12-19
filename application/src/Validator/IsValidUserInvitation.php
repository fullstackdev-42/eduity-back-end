<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"CLASS"})
 */
class IsValidUserInvitation extends Constraint {

    public $missingMessage = 'A user or email is missing.';
    public $tooManyIdentitiesMessage = 'A user and email can not be both set.';
    public $alreadyExistsMessage = 'User has already been invited.';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}