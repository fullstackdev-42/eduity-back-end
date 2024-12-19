<?php

namespace App\Eduity\ONetBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * OccupationData
 *
 * @ORM\Table(name="occupation_data")
 * @ORM\Entity
 */
class OccupationData
{
    /**
     * @var string
     *
     * @ORM\Column(name="onetsoc_code", type="string", length=10, nullable=false, options={"fixed"=true})
     */
    private $onetsocCode;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=150, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1000, nullable=false)
     */
    private $description;


}
