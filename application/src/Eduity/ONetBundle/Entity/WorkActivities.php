<?php

namespace App\Eduity\ONetBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * WorkActivities
 *
 * @ORM\Table(name="work_activities", indexes={@ORM\Index(name="element_id", columns={"element_id"}), @ORM\Index(name="onetsoc_code", columns={"onetsoc_code"}), @ORM\Index(name="scale_id", columns={"scale_id"})})
 * @ORM\Entity
 */
class WorkActivities
{
    /**
     * @var string
     *
     * @ORM\Column(name="data_value", type="decimal", precision=5, scale=2, nullable=false)
     */
    private $dataValue;

    /**
     * @var string|null
     *
     * @ORM\Column(name="n", type="decimal", precision=4, scale=0, nullable=true)
     */
    private $n;

    /**
     * @var string|null
     *
     * @ORM\Column(name="standard_error", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $standardError;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lower_ci_bound", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $lowerCiBound;

    /**
     * @var string|null
     *
     * @ORM\Column(name="upper_ci_bound", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $upperCiBound;

    /**
     * @var string|null
     *
     * @ORM\Column(name="recommend_suppress", type="string", length=1, nullable=true, options={"fixed"=true})
     */
    private $recommendSuppress;

    /**
     * @var string|null
     *
     * @ORM\Column(name="not_relevant", type="string", length=1, nullable=true, options={"fixed"=true})
     */
    private $notRelevant;

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
