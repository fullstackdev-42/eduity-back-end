<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Checks object if the assoicated organization contains the correct group
 */
class IsOrganizationGroupValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        if (!method_exists($value, 'getOrganization')) {
            throw new \InvalidArgumentException('@IsOrganizationGroup must be put on a class with a Organization relation');
        }
        if (!method_exists($value, 'getGroups')) {
            throw new \InvalidArgumentException('@IsOrganizationGroup must be put on a class with a Group relation');
        }

        $orgGroups = $value->getOrganization()->getGroups();
        foreach ($value->getGroups() as $group) {
            if (!$orgGroups->contains($group)) {
                $this->context->buildViolation($constraint->message)
                    ->atPath('groups')
                    ->addViolation();

                return;
            }
        }

    }
    
}