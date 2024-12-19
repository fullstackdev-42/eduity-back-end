<?php

namespace App\Eduity\ONetBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * SampleOfReportedTitles
 *
 * @ORM\Table(name="sample_of_reported_titles", indexes={@ORM\Index(name="onetsoc_code", columns={"onetsoc_code"})})
 * @ORM\Entity
 */
class SampleOfReportedTitles
{
    /**
     * @var string
     *
     * @ORM\Column(name="reported_job_title", type="string", length=150, nullable=false)
     */
    private $reportedJobTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="shown_in_my_next_move", type="string", length=1, nullable=false, options={"fixed"=true})
     */
    private $shownInMyNextMove;

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
