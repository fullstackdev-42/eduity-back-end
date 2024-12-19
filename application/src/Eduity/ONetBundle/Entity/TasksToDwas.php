<?php

namespace App\Eduity\ONetBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * TasksToDwas
 *
 * @ORM\Table(name="tasks_to_dwas", indexes={@ORM\Index(name="dwa_id", columns={"dwa_id"}), @ORM\Index(name="onetsoc_code", columns={"onetsoc_code"}), @ORM\Index(name="task_id", columns={"task_id"})})
 * @ORM\Entity
 */
class TasksToDwas
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_updated", type="date", nullable=false)
     */
    private $dateUpdated;

    /**
     * @var string
     *
     * @ORM\Column(name="domain_source", type="string", length=30, nullable=false)
     */
    private $domainSource;

    /**
     * @var \OccupationData
     *
     * @ORM\ManyToOne(targetEntity="OccupationData")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="onetsoc_code", referencedColumnName="onetsoc_code")
     * })
     */
    private $onetsocCode;

    /**
     * @var \TaskStatements
     *
     * @ORM\ManyToOne(targetEntity="TaskStatements")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="task_id", referencedColumnName="task_id")
     * })
     */
    private $task;

    /**
     * @var \DwaReference
     *
     * @ORM\ManyToOne(targetEntity="DwaReference")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dwa_id", referencedColumnName="dwa_id")
     * })
     */
    private $dwa;


}
