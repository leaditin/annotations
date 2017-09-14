<?php

declare(strict_types = 1);

namespace Leaditin\Annotations\Collector;

use Leaditin\Annotations\Reflection;

/**
 * Class MemoryCollector
 *
 * @package Leaditin\Annotations\Collector
 * @author Igor Vuckovic <igor@vuckovic.biz>
 */
class MemoryCollector extends AbstractCollector
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
