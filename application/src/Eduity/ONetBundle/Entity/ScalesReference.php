<?php

namespace App\Eduity\ONetBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScalesReference
 *
 * @ORM\Table(name="scales_reference")
 * @ORM\Entity
 */
class ScalesReference
{
    /**
     * @var string
     *
     * @ORM\Column(name="scale_id", type="string", length=3, nullable=false)
     */
    private $scaleId;

    /**
     * @var string
     *
     * @ORM\Column(name="scale_name", type="string", length=50, nullable=false)
     */
    private $scaleName;

    /**
     * @var string
     *
     * @ORM\Column(name="minimum", type="decimal", precision=1, scale=0, nullable=false)
     */
    private $minimum;

    /**
     * @var string
     *
     * @ORM\Column(name="maximum", type="decimal", precision=3, scale=0, nullable=false)
     */
    private $maximum;


}
