<?php

namespace App\Eduity\ONetBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * EteCategories
 *
 * @ORM\Table(name="ete_categories", indexes={@ORM\Index(name="scale_id", columns={"scale_id"}), @ORM\Index(name="IDX_214692751F1F2A24", columns={"element_id"})})
 * @ORM\Entity
 */
class EteCategories
{
    /**
     * @var string
     *
     * @ORM\Column(name="category", type="decimal", precision=3, scale=0, nullable=false)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="category_description", type="string", length=1000, nullable=false)
     */
    private $categoryDescription;

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
