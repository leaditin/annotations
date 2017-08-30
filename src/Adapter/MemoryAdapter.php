<?php

declare(strict_types = 1);

namespace Leaditin\Annotations\Adapter;

use Leaditin\Annotations\Reflection;

/**
 * Class MemoryAdapter
 *
 * @package Leaditin\Annotations\Adapter
 * @author Igor Vuckovic <igor@vuckovic.biz>
 */
class MemoryAdapter extends AbstractAdapter
{
    /**
     * {@inheritdoc}
     */
    public function read(string $class) : Reflection
    {
        if ($this->has($class) === false) {
            $this->write($class, $this->reader->read($class));
        }

        return $this->get($class);
    }

    /**
     * {@inheritdoc}
     */
    protected function write(string $class, Reflection $reflection)
    {
        $this->set($class, $reflection);
    }
}
