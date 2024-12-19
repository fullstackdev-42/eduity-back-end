<?php

namespace App\Eduity\ONetBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * UnspscReference
 *
 * @ORM\Table(name="unspsc_reference")
 * @ORM\Entity
 */
class UnspscReference
{
    /**
     * @var string
     *
     * @ORM\Column(name="commodity_code", type="decimal", precision=8, scale=0, nullable=false)
     */
    private $commodityCode;

    /**
     * @var string
     *
     * @ORM\Column(name="commodity_title", type="string", length=150, nullable=false)
     */
    private $commodityTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="class_code", type="decimal", precision=8, scale=0, nullable=false)
     */
    private $classCode;

    /**
     * @var string
     *
     * @ORM\Column(name="class_title", type="string", length=150, nullable=false)
     */
    private $classTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="family_code", type="decimal", precision=8, scale=0, nullable=false)
     */
    private $familyCode;

    /**
     * @var string
     *
     * @ORM\Column(name="family_title", type="string", length=150, nullable=false)
     */
    private $familyTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="segment_code", type="decimal", precision=8, scale=0, nullable=false)
     */
    private $segmentCode;

    /**
     * @var string
     *
     * @ORM\Column(name="segment_title", type="string", length=150, nullable=false)
     */
    private $segmentTitle;


}
