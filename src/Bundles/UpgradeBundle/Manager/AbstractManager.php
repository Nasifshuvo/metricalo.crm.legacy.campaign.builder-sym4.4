<?php


namespace App\Bundles\UpgradeBundle\Manager;

use Common\Symfony\Service\DoctrineORMHelper;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractManager
{
    use DoctrineORMHelper;

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }
}
