<?php

declare(strict_types=1);

namespace App\Bundles\MainBundle\Entity;

class SkillGameItem
{
    public function getPrice()
    {
        return 500;
    }

    public function getCurrency()
    {
        return 'EUR';
    }
}