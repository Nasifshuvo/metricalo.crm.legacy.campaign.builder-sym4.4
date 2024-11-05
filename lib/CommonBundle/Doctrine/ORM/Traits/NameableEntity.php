<?php

declare(strict_types=1);

namespace Common\Doctrine\ORM\Traits;

/**
 *  TODO: check up did we really need trait.
 *  TODO: possible ways - Abstract Classes, Mixin or independ Service Layer for application.
 */
trait NameableEntity
{
    /** @ORM\Column(type="string", length=255) */
    protected $name;

    /**
     * @param $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
