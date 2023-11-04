<?php
/**
 * Container.
 *
 * @license GPL-2.0-or-later
 *
 * @since 0.3.0
 */

declare(strict_types=1);

namespace SatisPress;

use Pimple\Container as PimpleContainer;
use Psr\Container\ContainerInterface;

/**
 * Container class.
 *
 * Extends PimpleContainer to satisfy the ContainerInterface.
 *
 * @since 0.3.0
 */
class Container extends PimpleContainer implements ContainerInterface
{
    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @since 0.3.0
     *
     * @param string $id identifier of the entry to look for
     *
     * @return mixed entry
     */
    public function get($id): mixed
    {
        return $this->offsetGet($id);
    }

    /**
     * Whether the container has an entry for the given identifier.
     *
     * @since 0.3.0
     *
     * @param string $id identifier of the entry to look for
     */
    public function has($id): bool
    {
        return $this->offsetExists($id);
    }
}
