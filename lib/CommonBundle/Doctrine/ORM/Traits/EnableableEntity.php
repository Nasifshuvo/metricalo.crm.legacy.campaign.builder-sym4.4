<?php

declare(strict_types=1);

namespace Common\Doctrine\ORM\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 *  TODO: check up did we really need trait.
 *  TODO: possible ways - Abstract Classes, Mixin or independ Service Layer for application.
 */
trait EnableableEntity
{
    /** @ORM\Column(type="boolean", length=1, options={"default": 1}) */
    protected bool $enabled = true;

    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    /** @return $this */
    public function setEnabled(bool $enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }
}
