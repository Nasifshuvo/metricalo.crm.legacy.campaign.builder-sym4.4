<?php

declare(strict_types=1);

namespace Common\Doctrine\ORM\Traits;

use Doctrine\ORM\Mapping as ORM;

trait MetaDataEntity
{
    /** @ORM\Column(type="json") */
    private $metaData = [];

    public function getMetaData(): array
    {
        return $this->metaData;
    }

    public function setMetaData(array $metaData): self
    {
        $this->metaData = $metaData;

        return $this;
    }

    public function getMetaDataValue(string $key)
    {
        return $this->metaData[$key] ?? null;
    }

    public function setMetaDataValue(string $key, $value): self
    {
        $this->metaData[$key] = $value;

        return $this;
    }
}
