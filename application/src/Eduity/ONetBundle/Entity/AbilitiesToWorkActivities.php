<?php

namespace App\Eduity\ONetBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbilitiesToWorkActivities
 *
 * @ORM\Table(name="abilities_to_work_activities", indexes={@ORM\Index(name="abilities_element_id", columns={"abilities_element_id"}), @ORM\Index(name="work_activities_element_id", columns={"work_activities_element_id"})})
 * @ORM\Entity
 */
class AbilitiesToWorkActivities
{
    /**
     * @var \ContentModelReference
     *
     * @ORM\ManyToOne(targetEntity="ContentModelReference")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="abilities_element_id", referencedColumnName="element_id")
     * })
     */
    private $abilitiesElement;

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
