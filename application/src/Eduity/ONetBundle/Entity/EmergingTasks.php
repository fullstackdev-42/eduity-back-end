<?php

namespace App\Eduity\ONetBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmergingTasks
 *
 * @ORM\Table(name="emerging_tasks", indexes={@ORM\Index(name="onetsoc_code", columns={"onetsoc_code"}), @ORM\Index(name="original_task_id", columns={"original_task_id"})})
 * @ORM\Entity
 */
class EmergingTasks
{
    /**
     * @var string
     *
     * @ORM\Column(name="task", type="string", length=1000, nullable=false)
     */
    private $task;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=8, nullable=false)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="writein_total", type="decimal", precision=3, scale=0, nullable=false)
     */
    private $writeinTotal;

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
     *   @ORM\JoinColumn(name="original_task_id", referencedColumnName="task_id")
     * })
     */
    private $originalTask;


}
