<?php

namespace App\Eduity\ONetBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * JobZoneReference
 *
 * @ORM\Table(name="job_zone_reference")
 * @ORM\Entity
 */
class JobZoneReference
{
    /**
     * @var string
     *
     * @ORM\Column(name="job_zone", type="decimal", precision=1, scale=0, nullable=false)
     */
    private $jobZone;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="experience", type="string", length=300, nullable=false)
     */
    private $experience;

    /**
     * @var string
     *
     * @ORM\Column(name="education", type="string", length=500, nullable=false)
     */
    private $education;

    /**
     * @var string
     *
     * @ORM\Column(name="job_training", type="string", length=300, nullable=false)
     */
    private $jobTraining;

    /**
     * @var string
     *
     * @ORM\Column(name="examples", type="string", length=500, nullable=false)
     */
    private $examples;

    /**
     * @var string
     *
     * @ORM\Column(name="svp_range", type="string", length=25, nullable=false)
     */
    private $svpRange;


}
