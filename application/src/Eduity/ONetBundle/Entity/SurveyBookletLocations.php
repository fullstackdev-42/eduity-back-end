<?php

namespace App\Eduity\ONetBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * SurveyBookletLocations
 *
 * @ORM\Table(name="survey_booklet_locations", indexes={@ORM\Index(name="element_id", columns={"element_id"}), @ORM\Index(name="scale_id", columns={"scale_id"})})
 * @ORM\Entity
 */
class SurveyBookletLocations
{
    /**
     * @var string
     *
     * @ORM\Column(name="survey_item_number", type="string", length=4, nullable=false)
     */
    private $surveyItemNumber;

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
