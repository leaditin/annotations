<?php

declare(strict_types = 1);

namespace Leaditin\Annotations;

use Leaditin\Annotations\Exception\ReflectionException;

/**
 * Class Reflection
 *
 * @package Leaditin\Annotations
 * @author Igor Vuckovic <igor@vuckovic.biz>
 */
class Reflection
{
    /** @var Collection|Annotation[] */
    protected $annotationsFromClass;

    /** @var Collection[] */
    protected $annotationsFromMethods;

    /** @var Collection[] */
    protected $annotationsFromProperties;

    /**
     * @param Collection $annotationsFromClass
     * @param Collection[] $annotationsFromMethods
     * @param Collection[] $annotationsFromProperties
     */
    public function __construct(Collection $annotationsFromClass, array $annotationsFromMethods, array $annotationsFromProperties)
    {
        $this->annotationsFromClass = $annotationsFromClass;
        $this->annotationsFromMethods = $annotationsFromMethods;
        $this->annotationsFromProperties = $annotationsFromProperties;
    }

    /**
     * @return Collection|Annotation[]
     */
    public function getClassAnnotations() : Collection
    {
        return $this->annotationsFromClass;
    }

    /**
     * @return Collection[]
     */
    public function getMethodsAnnotations() : array
    {
        return $this->annotationsFromMethods;
    }

    /**
     * @return Collection[]
     */
    public function getPropertiesAnnotations() : array
    {
        return $this->annotationsFromProperties;
    }

    /**
     * @param string $method
     * @return Collection|Annotation[]
     * @throws ReflectionException
     */
    public function getMethodAnnotations(string $method) : Collection
    {
        if (!array_key_exists($method, $this->annotationsFromMethods)) {
            throw ReflectionException::undefinedMethodAnnotations($method);
        }

        return $this->annotationsFromMethods[$method];
    }

    /**
     * @param string $property
     * @return Collection|Annotation[]
     * @throws ReflectionException
     */
    public function getPropertyAnnotations(string $property) : Collection
    {
        if (!array_key_exists($property, $this->annotationsFromProperties)) {
            throw ReflectionException::undefinedPropertyAnnotations($property);
        }

        return $this->annotationsFromProperties[$property];
    }
}
