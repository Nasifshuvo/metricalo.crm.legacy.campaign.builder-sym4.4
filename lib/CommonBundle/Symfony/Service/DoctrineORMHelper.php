<?php

declare(strict_types=1);

namespace Common\Symfony\Service;

use Doctrine\ORM\EntityManagerInterface;

/**
 * @author None
 */
trait DoctrineORMHelper
{
    /** @var EntityManagerInterface */
    protected $em;

    public function setEntityManager(EntityManagerInterface $em): void
    {
        $this->em = $em;
    }

    /**
     * @param $entity
     * @param bool $flush
     *
     * @return $this
     */
    public function save($entity, $flush = true)
    {
        $em = $this->em;

        if (is_array($entity)) {
            foreach ($entity as $item) {
                $this->save($item, false);
            }
        } else {
            $em->persist($entity);
        }

        if ($flush) {
            $em->flush();
        }

        return $this;
    }

    public function persist($entity)
    {
        $em = $this->em;
        $em->persist($entity);

        return $this;
    }

    public function flush(): void
    {
        $em = $this->em;
        $em->flush();
    }

    /**
     * @param $entity
     * @param bool $flush
     *
     * @return $this
     */
    public function remove($entity, $flush = true)
    {
        $em = $this->em;

        if (is_array($entity)) {
            foreach ($entity as $item) {
                $this->remove($item, false);
            }
        } else {
            $em->remove($entity);
        }

        if ($flush) {
            $em->flush();
        }

        return $this;
    }

    public function getRepo($class = null)
    {
        return $this->em->getRepository($class);
    }
}
