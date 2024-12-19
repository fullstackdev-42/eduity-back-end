<?php

namespace App\Eduity\ONetBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * DwaReference
 *
 * @ORM\Table(name="dwa_reference", indexes={@ORM\Index(name="element_id", columns={"element_id"}), @ORM\Index(name="iwa_id", columns={"iwa_id"})})
 * @ORM\Entity
 */
class DwaReference
{
    /**
     * @var string
     *
     * @ORM\Column(name="dwa_id", type="string", length=20, nullable=false)
     */
    private $dwaId;

    /**
     * @var string
     *
     * @ORM\Column(name="dwa_title", type="string", length=150, nullable=false)
     */
    private $dwaTitle;

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
     * @var \IwaReference
     *
     * @ORM\ManyToOne(targetEntity="IwaReference")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="iwa_id", referencedColumnName="iwa_id")
     * })
     */
    private $iwa;


}
