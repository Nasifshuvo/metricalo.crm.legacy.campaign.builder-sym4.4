<?php

declare(strict_types=1);

namespace Common\Doctrine\ORM\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 *  TODO: check up did we really need trait.
 *  TODO: possible ways - Abstract Classes, Mixin or independ Service Layer for application.
 */
trait CreableEntity
{
    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected ?\DateTime $createdAt = null;

    /** @return $this */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }
}
