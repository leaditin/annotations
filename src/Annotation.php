<?php

declare(strict_types = 1);

namespace Leaditin\Annotations;

use Leaditin\Annotations\Exception\AnnotationException;

/**
 * Class Annotation
 *
 * @package Leaditin\Annotations
 * @author Igor Vuckovic <igor@vuckovic.biz>
 */
class Annotation
{
    /** @var string */
    protected $name;

    /** @var array */
    protected $arguments;

    /**
     * @param string $name
     * @param array $arguments
     */
    public function __construct(string $name, array $arguments)
    {
        $this->name = $name;
        $this->arguments = $arguments;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getArguments() : array
    {
        return $this->arguments;
    }

    /**
     * @param int|string $name
     * @return bool
     */
    public function hasArgument($name) : bool
    {
        return array_key_exists($name, $this->arguments);
    }

    /**
     * @param int|string $name
     * @return null|int|bool|string|float|array
     * @throws AnnotationException
     */
    public function getArgument($name)
    {
        if (!$this->hasArgument($name)) {
            throw AnnotationException::undefinedArgument($this, $name);
        }

        return $this->arguments[$name];
    }
}
