<?php

declare(strict_types=1);

namespace Common\Doctrine\ORM\Traits;

use Common\Utils\LocationUtils;
use Doctrine\ORM\Mapping as ORM;

/**
 *  TODO: check up did we really need trait.
 *  TODO: possible ways - Abstract Classes, Mixin or independ Service Layer for application.
 */
trait CountryableEntity
{
    /** @ORM\Column(type="string", length=20, nullable=true) */
    protected ?string $countryCode = null;

    /** @return mixed */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /** @return $this */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = mb_strtoupper($countryCode);

        return $this;
    }

    public function getCountryName()
    {
        return LocationUtils::countryCodeToName($this->getCountryCode());
    }
}
