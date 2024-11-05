<?php

declare(strict_types=1);

namespace Common\Doctrine\ORM\Traits;

use DateTime;

/**
 *  TODO: check up did we really need trait.
 *  TODO: possible ways - Abstract Classes, Mixin or independ Service Layer for application.
 */
trait SoftDeleteableEntity
{
    /** @ORM\Column(type="datetime", nullable=true) */
    protected ?\DateTime $deletedAt = null;

    /** @return \DateTime */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTime $deletedAt = null): void
    {
        $this->deletedAt = $deletedAt;
    }

    public function isDeleted(): bool
    {
        return $this->getDeletedAt() instanceof \DateTime;
    }
}
