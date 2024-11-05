<?php

declare(strict_types=1);

namespace Common\Model\Traits;

/**
 * @author None
 */
trait WithDataClass
{
    private $dataClass;

    /**
     * @throws \Exception
     *
     * @return string
     */
    public function getDataClass()
    {
        if (!isset($this->dataClass)) {
            if (defined('static::DATA_CLASS')) {
                /* @phpstan-ignore-next-line */
                $this->dataClass = static::DATA_CLASS;
            }

            //just for legacy
            if (defined('static::ENTITY_CLASS')) {
                /* @phpstan-ignore-next-line */
                $this->dataClass = static::ENTITY_CLASS;
            }

            if (empty($this->dataClass)) {
                throw new \Exception('missing dataClass');
            }
        }

        return $this->dataClass;
    }

    /** @return $this */
    public function setDataClass(string $dataClass): self
    {
        $this->dataClass = $dataClass;

        return $this;
    }
}
