<?php

namespace App\Entity\ACL;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use App\Repository\ACL\SecurityResourceRepository;
use App\Entity\ACL\Interfaces\SecurityResourceInterface;
use App\Entity\ACL\Traits\SecurityResourceTrait;
use App\Entity\Traits\EntityUniqueIdTrait;

/**
 * @ORM\Entity(repositoryClass=SecurityResourceRepository::class)
 * @ORM\Table(
 *     name="security_resources",
 *     indexes={
 *         @ORM\Index(name="idx_security_resources_subject_class", columns={"subject_class"}),
 *         @ORM\Index(name="idx_security_resources_subject_id", columns={"subject_id"}),
 *         @ORM\Index(name="idx_security_resources_identity_class", columns={"identity_class"}),
 *         @ORM\Index(name="idx_security_resources_identity_id", columns={"identity_id"})
 *     },
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="uniq_security_resources", columns={"subject_class", "subject_id", "identity_class", "identity_id"})
 *     }
 * )
 */

class SecurityResource implements SecurityResourceInterface
{
    use EntityUniqueIdTrait;
    use BlameableEntity;
    use TimestampableEntity;
    use SecurityResourceTrait;
}
