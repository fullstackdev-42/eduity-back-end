<?php

namespace App\Eduity\ONetBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * SkillsToWorkActivities
 *
 * @ORM\Table(name="skills_to_work_activities", indexes={@ORM\Index(name="skills_element_id", columns={"skills_element_id"}), @ORM\Index(name="work_activities_element_id", columns={"work_activities_element_id"})})
 * @ORM\Entity
 */
class SkillsToWorkActivities
{
    /**
     * @var \ContentModelReference
     *
     * @ORM\ManyToOne(targetEntity="ContentModelReference")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="skills_element_id", referencedColumnName="element_id")
     * })
     */
    private $skillsElement;

    /**
     * @var \ContentModelReference
     *
     * @ORM\ManyToOne(targetEntity="ContentModelReference")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="work_activities_element_id", referencedColumnName="element_id")
     * })
     */
    private $workActivitiesElement;


}
