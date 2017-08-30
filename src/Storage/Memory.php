<?php

declare(strict_types = 1);

namespace Leaditin\Annotations\Storage;

use Leaditin\Annotations\AbstractStorage;
use Leaditin\Annotations\Reflection;

/**
 * Class Memory
 *
 * @package Leaditin\Annotations\Storage
 * @author Igor Vuckovic <igor@vuckovic.biz>
 */
class Memory extends AbstractStorage
{
    /**
     * {@inheritdoc}
     */
    public function read(string $class) : Reflection
    {
        if ($this->has($class) === false) {
            $reflection = $this->get($class);
            $this->write($class, $reflection);
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
