<?php

declare(strict_types=1);

namespace Common\Doctrine\ORM\Traits;

use App\Bundles\UpgradeBundle\Model\DataEnrichment\ProviderResponse;
use Common\Utils\DateUtils;
use DateTime;

trait ResolveableDataEntity
{
    /** @ORM\Column(type="string", nullable=true) */
    protected $lastResolveStatus;

    /** @ORM\Column(type="string", nullable=true) */
    protected $lastResolveMessage;

    /** @ORM\Column(type="string", nullable=true) */
    protected $lastResolveCode;

    /** @ORM\Column(type="datetime", nullable=true) */
    protected $lastResolveAt;

    /**
     * @var array
     *
     * @ORM\Column(type="json", nullable=true)
     */
    protected $resolveData;

    /** @ORM\Column(type="string", nullable=true) */
    protected $resolveLevel;

    /** @ORM\Column(type="datetime", nullable=true) */
    protected $lastSuccessfulResolveAt;

    public function getDaysSinceLastResolve(): ?int
    {
        if (!$this->lastResolveAt instanceof \DateTime) {
            return null;
        }

        return DateUtils::getDaysSinceDate($this->lastResolveAt);
    }

    /** @return mixed */
    public function getLastResolveStatus()
    {
        return $this->lastResolveStatus;
    }

    public function setResolveResponse(ProviderResponse $pr)
    {
        $this->lastResolveStatus = $pr->getLastResolveStatus();
        $this->lastResolveMessage = $pr->getLastResolveMessage();
        $this->lastResolveCode = $pr->getLastResolveCode();
        $this->lastResolveAt = $pr->getLastResolveAt();

        if ($pr->getLastResolveStatus() === ProviderResponse::SUCCESS) {
            $this->resolveData = $pr->getResolveData();
            $this->resolveLevel = $pr->getResolveLevel();
            $this->lastSuccessfulResolveAt = $pr->getLastSuccessfulResolveAt();
        }

        return $this;
    }

    /** @return mixed */
    public function getLastResolveMessage()
    {
        return $this->lastResolveMessage;
    }

    /** @return mixed */
    public function getLastResolveCode()
    {
        return $this->lastResolveCode;
    }

    /** @return mixed */
    public function getLastResolveAt()
    {
        return $this->lastResolveAt;
    }

    public function getResolveData(): array
    {
        return $this->resolveData;
    }

    /** @return mixed */
    public function getResolveLevel()
    {
        return $this->resolveLevel;
    }

    /** @return mixed */
    public function getLastSuccessfulResolveAt()
    {
        return $this->lastSuccessfulResolveAt;
    }
}
