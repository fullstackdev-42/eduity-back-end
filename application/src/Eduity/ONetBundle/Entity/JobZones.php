<?php

namespace App\Eduity\ONetBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * JobZones
 *
 * @ORM\Table(name="job_zones", indexes={@ORM\Index(name="job_zone", columns={"job_zone"}), @ORM\Index(name="onetsoc_code", columns={"onetsoc_code"})})
 * @ORM\Entity
 */
class JobZones
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_updated", type="date", nullable=false)
     */
    private $dateUpdated;

    /**
     * @var string
     *
     * @ORM\Column(name="domain_source", type="string", length=30, nullable=false)
     */
    private $domainSource;

    /**
     * @var \OccupationData
     *
     * @ORM\ManyToOne(targetEntity="OccupationData")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="onetsoc_code", referencedColumnName="onetsoc_code")
     * })
     */
    private $onetsocCode;

    /**
     * @var \JobZoneReference
     *
     * @ORM\ManyToOne(targetEntity="JobZoneReference")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="job_zone", referencedColumnName="job_zone")
     * })
     */
    private $jobZone;


}
