<?php

namespace App\Eduity\ONetBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * IwaReference
 *
 * @ORM\Table(name="iwa_reference", indexes={@ORM\Index(name="element_id", columns={"element_id"})})
 * @ORM\Entity
 */
class IwaReference
{
    /**
     * @var string
     *
     * @ORM\Column(name="iwa_id", type="string", length=20, nullable=false)
     */
    private $iwaId;

    /**
     * @var string
     *
     * @ORM\Column(name="iwa_title", type="string", length=150, nullable=false)
     */
    private $iwaTitle;

    /**
     * @var \ContentModelReference
     *
     * @ORM\ManyToOne(targetEntity="ContentModelReference")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="element_id", referencedColumnName="element_id")
     * })
     */
    private $element;


}
