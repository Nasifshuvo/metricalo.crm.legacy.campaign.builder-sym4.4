<?php

declare(strict_types=1);

namespace Common\Doctrine\ORM\Traits;

trait UniqueReferenceIdEntity
{
    /** @ORM\Column(type="string", length=255, nullable=true, unique=true) */
    protected $referenceId;

    public function __toString()
    {
        return (string) $this->getReferenceId();
    }

    /** @return mixed */
    public function getReferenceId()
    {
        return $this->referenceId;
    }

    /** @return $this */
    public function setReferenceId($referenceId): self
    {
        $this->referenceId = $referenceId;

        return $this;
    }
}
