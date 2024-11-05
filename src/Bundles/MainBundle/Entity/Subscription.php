<?php

namespace App\Bundles\MainBundle\Entity;

class Subscription
{

    public $uniqueIdentifier = 'SUB12341234';

    public $status = 'Active';

    public $nextBillingDate;

    public $trialEndDate;

    public function __construct()
    {
        $this->trialEndDate = new \DateTime();
        $this->nextBillingDate = new \DateTime();

    }

    public function getTrialEndDate()
    {
        return $this->trialEndDate;
    }

    public function setTrialEndDate($trialEndDate): self
    {
        $this->trialEndDate = $trialEndDate;
        return $this;
    }

    public function getUniqueIdentifier(): string
    {
        return $this->uniqueIdentifier;
    }

    public function setUniqueIdentifier(string $uniqueIdentifier): self
    {
        $this->uniqueIdentifier = $uniqueIdentifier;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getNextBillingDate(): \DateTime
    {
        return $this->nextBillingDate;
    }

    public function setNextBillingDate(\DateTime $nextBillingDate): self
    {
        $this->nextBillingDate = $nextBillingDate;
        return $this;
    }
}