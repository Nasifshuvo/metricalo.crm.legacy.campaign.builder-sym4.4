<?php

declare(strict_types=1);

namespace App\Bundles\UpgradeBundle\Entity\PageTemplate;

class Language
{

    protected $code;

    protected $name;

    protected $direction;

    public function __construct(string $code, string $name, string $direction = 'ltr')
    {
        $this->code = $code;
        $this->name = $name;
        $this->direction = $direction;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }
}