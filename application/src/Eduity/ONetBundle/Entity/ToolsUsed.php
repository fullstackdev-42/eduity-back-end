<?php

namespace App\Eduity\ONetBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * ToolsUsed
 *
 * @ORM\Table(name="tools_used", indexes={@ORM\Index(name="commodity_code", columns={"commodity_code"}), @ORM\Index(name="onetsoc_code", columns={"onetsoc_code"})})
 * @ORM\Entity
 */
class ToolsUsed
{
    /**
     * @var string
     *
     * @ORM\Column(name="example", type="string", length=150, nullable=false)
     */
    private $example;

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
