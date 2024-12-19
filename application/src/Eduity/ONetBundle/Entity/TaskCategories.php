<?php

namespace App\Eduity\ONetBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * TaskCategories
 *
 * @ORM\Table(name="task_categories", indexes={@ORM\Index(name="IDX_26E00DC7F73142C2", columns={"scale_id"})})
 * @ORM\Entity
 */
class TaskCategories
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
     * @var \ScalesReference
     *
     * @ORM\ManyToOne(targetEntity="ScalesReference")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="scale_id", referencedColumnName="scale_id")
     * })
     */
    private $scale;


}
