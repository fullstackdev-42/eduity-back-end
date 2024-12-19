<?php

namespace App\Eduity\ONetBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * LevelScaleAnchors
 *
 * @ORM\Table(name="level_scale_anchors", indexes={@ORM\Index(name="element_id", columns={"element_id"}), @ORM\Index(name="scale_id", columns={"scale_id"})})
 * @ORM\Entity
 */
class LevelScaleAnchors
{
    /**
     * @var string
     *
     * @ORM\Column(name="anchor_value", type="decimal", precision=3, scale=0, nullable=false)
     */
    private $anchorValue;

    /**
     * @var string
     *
     * @ORM\Column(name="anchor_description", type="string", length=1000, nullable=false)
     */
    private $anchorDescription;

    /**
     * @var \ContentModelReference
     *
     * @ORM\ManyToOne(targetEntity="ContentModelReference")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="element_id", referencedColumnName="element_id")
     * })
     */
    private $element;

    /**
     * @var \ScalesReference
     *
     * @ORM\ManyToOne(targetEntity="ScalesReference")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="scale_id", referencedColumnName="scale_id")
     * })
     */
    private $scale;


}
