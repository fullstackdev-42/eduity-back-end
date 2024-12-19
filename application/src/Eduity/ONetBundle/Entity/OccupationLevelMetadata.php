<?php

namespace App\Eduity\ONetBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * OccupationLevelMetadata
 *
 * @ORM\Table(name="occupation_level_metadata", indexes={@ORM\Index(name="onetsoc_code", columns={"onetsoc_code"})})
 * @ORM\Entity
 */
class OccupationLevelMetadata
{
    /**
     * @var string
     *
     * @ORM\Column(name="item", type="string", length=150, nullable=false)
     */
    private $item;

    /**
     * @var string|null
     *
     * @ORM\Column(name="response", type="string", length=75, nullable=true)
     */
    private $response;

    /**
     * @var string|null
     *
     * @ORM\Column(name="n", type="decimal", precision=4, scale=0, nullable=true)
     */
    private $n;

    /**
     * @var string|null
     *
     * @ORM\Column(name="percent", type="decimal", precision=4, scale=1, nullable=true)
     */
    private $percent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_updated", type="date", nullable=false)
     */
    private $dateUpdated;

    /**
     * @var \OccupationData
     *
     * @ORM\ManyToOne(targetEntity="OccupationData")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="onetsoc_code", referencedColumnName="onetsoc_code")
     * })
     */
    private $onetsocCode;


}
