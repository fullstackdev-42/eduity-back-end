<?php

namespace App\Eduity\ONetBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * SkillsToWorkContext
 *
 * @ORM\Table(name="skills_to_work_context", indexes={@ORM\Index(name="skills_element_id", columns={"skills_element_id"}), @ORM\Index(name="work_context_element_id", columns={"work_context_element_id"})})
 * @ORM\Entity
 */
class SkillsToWorkContext
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
     *   @ORM\JoinColumn(name="work_context_element_id", referencedColumnName="element_id")
     * })
     */
    private $workContextElement;


}
