<?php

namespace App\Eduity\ONetBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * AlternateTitles
 *
 * @ORM\Table(name="alternate_titles", indexes={@ORM\Index(name="onetsoc_code", columns={"onetsoc_code"})})
 * @ORM\Entity
 */
class AlternateTitles
{
    /**
     * @var string
     *
     * @ORM\Column(name="alternate_title", type="string", length=250, nullable=false)
     */
    private $alternateTitle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="short_title", type="string", length=150, nullable=true)
     */
    private $shortTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="sources", type="string", length=50, nullable=false)
     */
    private $sources;

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
