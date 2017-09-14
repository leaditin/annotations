<?php

declare(strict_types = 1);

namespace Leaditin\Annotations\Collector;

use Leaditin\Annotations\Reader\ReaderInterface;
use Leaditin\Annotations\Reflection;

/**
 * Class AbstractCollector
 *
 * @package Leaditin\Annotations\Collector
 * @author Igor Vuckovic <igor@vuckovic.biz>
 */
abstract class AbstractCollector implements CollectorInterface
{
    /** @var ReaderInterface */
    protected $reader;

    /** @var Reflection[] */
    protected $reflections;

    /**
     * @param ReaderInterface $reader
     */
    public function __construct(ReaderInterface $reader)
    {
        $this->reader = $reader;
        $this->reflections = [];
    }

    /**
     * @param string $class
     * @return Reflection
     */
    protected function get(string $class) : Reflection
    {
        return $this->reflections[$class];
    }

    /**
     * @param string $class
     * @param Reflection $reflection
     */
    protected function set(string $class, Reflection $reflection)
    {
        $this->reflections[$class] = $reflection;
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
