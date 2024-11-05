<?php

declare(strict_types=1);

namespace Common\Doctrine\ORM\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author None
 */
trait TypeableEntity
{
    /**
     * @var string
     * @ORM\Column(type="string", length=20)
     */
    protected $type;

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /** @return string */
    public function getType()
    {
        return $this->type;
    }
}
