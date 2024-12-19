<?php

namespace App\Eduity\ONetBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContentModelReference
 *
 * @ORM\Table(name="content_model_reference")
 * @ORM\Entity
 */
class ContentModelReference
{
    /**
     * @var string
     *
     * @ORM\Column(name="element_id", type="string", length=20, nullable=false)
     */
    private $elementId;

    /**
     * @var string
     *
     * @ORM\Column(name="element_name", type="string", length=150, nullable=false)
     */
    private $elementName;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1500, nullable=false)
     */
    private $description;


}
