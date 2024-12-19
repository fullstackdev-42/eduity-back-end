<?php

namespace App\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Entity\UserInvitation;
use App\Repository\UserInvitationRepository;

class IsValidUserInvitationValidator extends ConstraintValidator
{

    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$value instanceof UserInvitation) {
            throw new \InvalidArgumentException('@IsValidUserInvitation constraint must be put on a property containing a UserInvitation object');
        }

        /** @var UserInvitationRepository */
        $userInviteRepo = $this->em->getRepository(UserInvitation::class);
        if ($value->getUser() === null && $value->getEmail() === null) {
            $this->context->buildViolation($constraint->missingMessage)
                ->atPath('user')
                ->atPath('email')
                ->addViolation();
        } else if ($value->getUser() !== null && $value->getEmail() !== null) {
            $this->context->buildViolation($constraint->tooManyIdentitiesMessage)
                ->atPath('user')
                ->atPath('email')
                ->addViolation();
        } else {
            $invites = $userInviteRepo->findByUserOrEmailAndOrganization($value->getUser(), $value->getEmail(), $value->getOrganization());
            if (!$invites->isEmpty()) {
                $this->context->buildViolation($constraint->alreadyExistsMessage)
                ->atPath('user')
                ->atPath('email')
                ->addViolation();
            }
        }

    }
    
}