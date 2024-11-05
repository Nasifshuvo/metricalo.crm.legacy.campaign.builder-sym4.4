<?php

declare(strict_types=1);

namespace Common\Doctrine\ORM\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 *  TODO: check up did we really need trait.
 *  TODO: possible ways - Abstract Classes, Mixin or independ Service Layer for application.
 */
trait ModeableEntity
{
    /** @ORM\Column(type="string", length=50) */
    protected ?string $mode = null;

    public function getMode(): string
    {
        return $this->mode;
    }

    /** @return $this */
    public function setMode(string $mode): self
    {
        $this->mode = $mode;

        return $this;
    }
}
