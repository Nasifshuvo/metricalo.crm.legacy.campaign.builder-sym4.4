<?php

declare(strict_types=1);

namespace Common\Doctrine\ORM\Traits;

use DateTime;

/**
 *  TODO: check up did we really need trait.
 *  TODO: possible ways - Abstract Classes, Mixin or independ Service Layer for application.
 */
trait SeenTrackableEntity
{
    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected ?\DateTime $firstSeenAt = null;

    /** @ORM\Column(type="datetime") */
    protected ?\DateTime $lastSeenAt;

    /** @return mixed */
    public function getFirstSeenAt()
    {
        return $this->firstSeenAt;
    }

    /** @return $this */
    public function setFirstSeenAt($firstSeenAt): self
    {
        $this->firstSeenAt = $firstSeenAt;

        return $this;
    }

    /** @return mixed */
    public function getLastSeenAt()
    {
        return $this->lastSeenAt;
    }

    /** @return $this */
    public function setLastSeenAt($lastSeenAt): self
    {
        $this->lastSeenAt = $lastSeenAt;

        return $this;
    }

    public function seenNow(): void
    {
        $now = new \DateTime();

        if (!$this->firstSeenAt) {
            $this->firstSeenAt = $now;
        }

        $this->lastSeenAt = $now;
    }
}
