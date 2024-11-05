<?php

declare(strict_types=1);

namespace Common\Model\Traits;

/**
 * @author None
 */
trait WithData
{
    private $data;

    /** @return mixed */
    public function getData()
    {
        return $this->data;
    }

    /** @return $this */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
}
