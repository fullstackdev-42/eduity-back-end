<?php

namespace App\Eduity\ONetBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * TaskStatements
 *
 * @ORM\Table(name="task_statements", indexes={@ORM\Index(name="onetsoc_code", columns={"onetsoc_code"})})
 * @ORM\Entity
 */
class TaskStatements
{
    /**
     * @var string
     *
     * @ORM\Column(name="task_id", type="decimal", precision=8, scale=0, nullable=false)
     */
    private $taskId;

    /**
     * @var string
     *
     * @ORM\Column(name="task", type="string", length=1000, nullable=false)
     */
    private $task;

    /**
     * @var string|null
     *
     * @ORM\Column(name="task_type", type="string", length=12, nullable=true)
     */
    private $taskType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="incumbents_responding", type="decimal", precision=4, scale=0, nullable=true)
     */
    private $incumbentsResponding;

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


}
