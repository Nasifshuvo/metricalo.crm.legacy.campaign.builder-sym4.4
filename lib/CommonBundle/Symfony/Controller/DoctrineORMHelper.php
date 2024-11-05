<?php

declare(strict_types=1);

namespace Common\Symfony\Controller;

use Doctrine\Persistence\ObjectRepository;

/**
 * @author None
 */
trait DoctrineORMHelper
{
    /** @param $entity */
    public function save($entity, bool $flush = true): void
    {
        $em = $this->getDoctrine()->getManager();

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
    }

    public function emCacheClear(): void
    {
        $em = $this->getDoctrine()->getManager();
        $em->clear();
    }

    public function flush(): void
    {
        $em = $this->getDoctrine()->getManager();
        $em->flush();
    }

    /**
     * @param $entity
     * @param bool $flush
     */
    public function remove($entity, $flush = true): void
    {
        $em = $this->getDoctrine()->getManager();

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
    }

    public function getRepo($class = null): ObjectRepository
    {
        return $this->getDoctrine()->getManager()->getRepository($class);
    }
}
