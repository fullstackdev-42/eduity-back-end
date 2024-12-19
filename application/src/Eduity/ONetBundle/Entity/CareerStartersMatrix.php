<?php

namespace App\Eduity\ONetBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * CareerStartersMatrix
 *
 * @ORM\Table(name="career_starters_matrix", indexes={@ORM\Index(name="onetsoc_code", columns={"onetsoc_code"}), @ORM\Index(name="related_onetsoc_code", columns={"related_onetsoc_code"})})
 * @ORM\Entity
 */
class CareerStartersMatrix
{
    /**
     * @var string
     *
     * @ORM\Column(name="related_index", type="decimal", precision=3, scale=0, nullable=false)
     */
    private $relatedIndex;

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
     * @var \OccupationData
     *
     * @ORM\ManyToOne(targetEntity="OccupationData")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="related_onetsoc_code", referencedColumnName="onetsoc_code")
     * })
     */
    private $relatedOnetsocCode;


}
