<?php

declare(strict_types=1);

namespace Common\Doctrine\ORM\Traits;

/**
 *  TODO: check up did we really need trait.
 *  TODO: possible ways - Abstract Classes, Mixin or independ Service Layer for application.
 */
trait StatusableEntity
{
    /** @ORM\Column(type="string", length=20) */
    protected ?string $status = null;

    /**
     * @param string $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /** @return string */
    public function getStatus()
    {
        return $this->status;
    }
}
