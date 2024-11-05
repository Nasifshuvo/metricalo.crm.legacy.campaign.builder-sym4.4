<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\AdminBundle\Filter;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @final since sonata-project/admin-bundle 3.52
 *
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class FilterFactory implements FilterFactoryInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var string[]
     */
    protected $types;

    /**
     * @param string[] $types
     */
    public function __construct(ContainerInterface $container, array $types = [])
    {
        $this->container = $container;
        $this->types = $types;
    }

    public function create($name, $type, array $options = [])
    {
        if (!$type) {
            throw new \RuntimeException('The type must be defined');
        }

        $id = $this->types[$type] ?? false;

        if ($id) {
            $filter = $this->container->get($id);

            if ($filter && !class_exists($type)) {
                @trigger_error(sprintf(
                    'Referencing a filter by name (%s) is deprecated since version 3.57 and will be removed in 4.0.'
                    .' Use the fully-qualified type class name instead (%s).',
                    $type,
                    \get_class($filter)
                ), \E_USER_DEPRECATED);
            }
        } elseif (class_exists($type)) {
            // NEXT_MAJOR: Remove this "elseif" block
            @trigger_error(sprintf(
                'Not declaring a filter as service is deprecated since sonata-project/admin-bundle 3.95'
                .' and will not work in 4.0.'
                .' You MUST register a service with class name (%s) instead.',
                $type,
            ), \E_USER_DEPRECATED);
            $filter = new $type();
        } else {
            throw new \RuntimeException(sprintf('No attached service to type named `%s`', $type));
        }

        if (!$filter instanceof FilterInterface) {
            throw new \RuntimeException(sprintf('The service `%s` must implement `FilterInterface`', $type));
        }

        $filter->initialize($name, $options);

        return $filter;
    }
}
