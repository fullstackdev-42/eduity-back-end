<?php

namespace App\Eduity\ONetBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbilitiesToWorkContext
 *
 * @ORM\Table(name="abilities_to_work_context", indexes={@ORM\Index(name="abilities_element_id", columns={"abilities_element_id"}), @ORM\Index(name="work_context_element_id", columns={"work_context_element_id"})})
 * @ORM\Entity
 */
class AbilitiesToWorkContext
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
     *   @ORM\JoinColumn(name="work_context_element_id", referencedColumnName="element_id")
     * })
     */
    private $workContextElement;


}
