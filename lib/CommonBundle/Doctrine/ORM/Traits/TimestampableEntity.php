<?php

declare(strict_types=1);

namespace Common\Doctrine\ORM\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @author None
 */
trait TimestampableEntity
{
    use CreableEntity;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $updatedAt;

    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /** @return \DateTime */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
