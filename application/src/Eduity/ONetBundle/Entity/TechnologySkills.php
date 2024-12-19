<?php

namespace App\Eduity\ONetBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * TechnologySkills
 *
 * @ORM\Table(name="technology_skills", indexes={@ORM\Index(name="commodity_code", columns={"commodity_code"}), @ORM\Index(name="onetsoc_code", columns={"onetsoc_code"})})
 * @ORM\Entity
 */
class TechnologySkills
{
    /**
     * @var string
     *
     * @ORM\Column(name="example", type="string", length=150, nullable=false)
     */
    private $example;

    /**
     * @var string
     *
     * @ORM\Column(name="hot_technology", type="string", length=1, nullable=false, options={"fixed"=true})
     */
    private $hotTechnology;

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
     * @var \UnspscReference
     *
     * @ORM\ManyToOne(targetEntity="UnspscReference")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="commodity_code", referencedColumnName="commodity_code")
     * })
     */
    private $commodityCode;


}
