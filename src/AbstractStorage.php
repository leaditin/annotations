<?php

declare(strict_types = 1);

namespace Leaditin\Annotations;

use Leaditin\Annotations\Exception\ReaderException;

/**
 * Class AbstractStorage
 *
 * @package Leaditin\Annotations
 * @author Igor Vuckovic <igor@vuckovic.biz>
 */
abstract class AbstractStorage implements StorageInterface
{
    /** @var Reader */
    protected $reader;

    /** @var Reflection[] */
    protected $reflections;

    /**
     * @param Reader|null $reader
     */
    public function __construct(Reader $reader = null)
    {
        if ($reader === null) {
            $reader = new Reader();
        }

        $this->reader = $reader;
        $this->reflections = [];
    }

    /**
     * @param string $class
     * @return Reflection
     * @throws ReaderException
     */
    protected function get(string $class) : Reflection
    {
        return $this->reader->parse($class);
    }

    /**
     * @param string $class
     * @param Reflection $reflection
     * @return StorageInterface
     */
    protected function set(string $class, Reflection $reflection) : StorageInterface
    {
        $this->reflections[$class] = $reflection;

        return $this;
    }

    /**
     * @param string $class
     * @return bool
     */
    protected function has(string $class) : bool
    {
        return array_key_exists($class, $this->reflections);
    }

    /**
     * @param string $class
     * @param Reflection $reflection
     */
    abstract protected function write(string $class, Reflection $reflection);
}
