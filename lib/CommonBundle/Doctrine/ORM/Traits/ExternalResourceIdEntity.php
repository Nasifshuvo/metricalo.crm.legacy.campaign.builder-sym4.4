<?php

declare(strict_types=1);

namespace Common\Doctrine\ORM\Traits;

use Doctrine\ORM\Mapping as ORM;

trait ExternalResourceIdEntity
{
    /** @ORM\Column(type="string", length=255, nullable=true) */
    public $externalResourceId;

    /** @return mixed */
    public function getExternalResourceId()
    {
        return $this->externalResourceId;
    }

    /** @return $this */
    public function setExternalResourceId($externalResourceId): self
    {
        $this->externalResourceId = $externalResourceId;

        return $this;
    }
}
