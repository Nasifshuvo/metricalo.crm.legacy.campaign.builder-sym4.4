<?php

declare(strict_types=1);

namespace Common\Doctrine\ORM\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author None
 * TODO: check up did we really need trait.
 * TODO: possible ways - Abstract Classes, Mixin or independ Service Layer for application
 */
trait CommentableEntity
{
    /** @ORM\Column(type="string", length=255, nullable=true) */
    protected ?string $comment = null;

    /** @return string */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /** @return $this */
    public function setComment(?string $comment)
    {
        $this->comment = $comment;

        return $this;
    }
}
